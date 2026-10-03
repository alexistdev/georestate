<?php

namespace Tests\Feature;

use App\Providers\GeoLicenseServiceProvider;
use App\Services\GeoLicense\LicenseActivationService;
use App\Services\GeoLicense\LicenseHolder;
use App\Services\GeoLicense\LicenseVerificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LicenseTest extends TestCase
{
    use RefreshDatabase;

    private LicenseHolder $holder;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'geolicense.server_url' => 'https://license.test',
            'geolicense.license_key' => 'GEOLIC-TEST-KEY',
            'geolicense.product_sku' => 'GEORESTATE',
        ]);
        $this->holder = app(LicenseHolder::class);
        $this->holder->forget();
    }

    private function suksesActivate(): array
    {
        return ['status' => true, 'messages' => ['License activated successfully.'], 'payload' => ['token' => 'jwt-token']];
    }

    public function test_activation_sends_product_sku_and_stores_token(): void
    {
        Http::fake(['license.test/api/v1/licenses/activate' => Http::response($this->suksesActivate())]);

        app(LicenseActivationService::class)->activate();

        $this->assertSame('jwt-token', $this->holder->getToken());
        $this->assertTrue($this->holder->isValid());
        Http::assertSent(fn (Request $request) => $request['licenseKey'] === 'GEOLIC-TEST-KEY'
            && $request['productSku'] === 'GEORESTATE'
            && filled($request['machineId']));
    }

    public function test_rejected_activation_does_not_expose_full_license_key(): void
    {
        Http::fake(['*' => Http::response(['status' => false, 'messages' => ['License not found: GEOLIC-TEST-KEY']], 404)]);

        try {
            app(LicenseActivationService::class)->activate();
            $this->fail('Aktivasi seharusnya gagal.');
        } catch (\RuntimeException $e) {
            $this->assertStringContainsString('License not found: GEOLIC-T****', $e->getMessage());
            $this->assertStringNotContainsString('GEOLIC-TEST-KEY', $e->getMessage());
        }
    }

    public function test_activation_requires_product_sku(): void
    {
        config(['geolicense.product_sku' => null]);
        Http::fake();

        $this->expectExceptionMessage('GEOLICENSE_PRODUCT_SKU is not set');
        app(LicenseActivationService::class)->activate();
    }

    public function test_failed_activation_on_boot_does_not_crash_and_waits_before_retrying(): void
    {
        Http::fake(['*' => Http::response(['status' => false, 'messages' => ['License not found']], 404)]);
        $provider = new GeoLicenseServiceProvider($this->app);

        $provider->boot();
        $provider->boot();

        Http::assertSentCount(1);
        $this->assertNull($this->holder->getToken());
        $this->assertFalse($this->holder->isValid());
    }

    public function test_changing_license_key_invalidates_cached_token_and_reactivates(): void
    {
        Http::fake(['license.test/api/v1/licenses/activate' => Http::sequence()
            ->push($this->suksesActivate())
            ->push(['status' => false, 'messages' => ['License not found: KEY-SALAH']], 404)]);
        $provider = new GeoLicenseServiceProvider($this->app);

        $provider->boot();
        $this->get(route('front.home'))->assertOk();

        // Key di .env diganti dengan key yang salah: token lama tidak boleh dipakai lagi.
        config(['geolicense.license_key' => 'KEY-SALAH']);
        $this->assertFalse($this->holder->isValid());
        $this->get(route('front.home'))->assertStatus(503);

        $provider->boot();
        Http::assertSentCount(2);
        Http::assertSent(fn (Request $request) => $request['licenseKey'] === 'KEY-SALAH');
        $this->assertNull($this->holder->getToken());
        $this->get(route('front.home'))->assertStatus(503);
    }

    public function test_fixing_license_key_retries_activation_without_waiting_for_cooldown(): void
    {
        Http::fake(['license.test/api/v1/licenses/activate' => Http::sequence()
            ->push(['status' => false, 'messages' => ['License not found']], 404)
            ->push($this->suksesActivate())]);
        $provider = new GeoLicenseServiceProvider($this->app);

        config(['geolicense.license_key' => 'KEY-SALAH']);
        $provider->boot();
        $this->assertFalse($this->holder->isValid());

        config(['geolicense.license_key' => 'GEOLIC-TEST-KEY']);
        $provider->boot();

        Http::assertSentCount(2);
        $this->assertTrue($this->holder->isValid());
        $this->get(route('front.home'))->assertOk();
    }

    public function test_verification_sends_product_sku_and_updates_validity(): void
    {
        $this->holder->setToken('jwt-token');
        Http::fake(['license.test/api/v1/licenses/verify' => Http::sequence()
            ->push(['status' => true, 'messages' => ['ok'], 'payload' => []])
            ->push(['status' => false, 'messages' => ['License has expired']], 402)]);

        app(LicenseVerificationService::class)->verify();
        $this->assertTrue($this->holder->isValid());

        app(LicenseVerificationService::class)->verify();
        $this->assertFalse($this->holder->isValid());

        Http::assertSent(fn (Request $request) => $request['token'] === 'jwt-token' && $request['productSku'] === 'GEORESTATE');
    }

    public function test_unreachable_server_keeps_current_validity(): void
    {
        $this->holder->setToken('jwt-token');
        $this->holder->setValid(true);
        Http::fake(fn () => throw new \Illuminate\Http\Client\ConnectionException('timeout'));

        app(LicenseVerificationService::class)->verify();

        $this->assertTrue($this->holder->isValid());
    }

    public function test_valid_license_allows_requests(): void
    {
        $this->holder->setToken('jwt-token');
        $this->holder->setValid(true);

        $this->get(route('front.home'))->assertOk();
    }

    public function test_invalid_license_blocks_web_and_api_requests(): void
    {
        $this->holder->setToken('jwt-token');
        $this->holder->setValid(false);
        $this->travel(2)->hours(); // di luar masa tenggang

        $this->get(route('front.home'))
            ->assertStatus(503)
            ->assertSee('Lisensi aplikasi tidak valid');

        $this->getJson(route('front.home'))
            ->assertStatus(503)
            ->assertJson(['status' => false]);
    }

    public function test_grace_period_allows_requests_shortly_after_last_valid_check(): void
    {
        $this->holder->setToken('jwt-token');
        $this->holder->setValid(true);
        $this->holder->setValid(false); // terakhir valid barusan

        $this->travel(10)->minutes();
        $this->get(route('front.home'))->assertOk();

        $this->travel(30)->minutes();
        $this->get(route('front.home'))->assertStatus(503);
    }

    public function test_excluded_path_bypasses_check(): void
    {
        $this->assertFalse($this->holder->isValid());

        $this->get('/up')->assertOk();
        $this->get(route('front.home'))->assertStatus(503);
    }

    public function test_app_without_license_key_is_blocked(): void
    {
        config(['geolicense.license_key' => null]);
        Http::fake();

        (new GeoLicenseServiceProvider($this->app))->boot();

        Http::assertNothingSent();
        $this->get(route('front.home'))->assertStatus(503);
    }
}
