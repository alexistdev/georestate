<?php

namespace Tests\Feature;

use App\Models\Agent;
use App\Models\Gambar;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Fase 6A: branding, halaman error, SEO, dan reset password oleh admin.
 */
class TampilanTest extends TestCase
{
    use RefreshDatabase;

    public function test_pages_use_georestate_logo_and_favicon_instead_of_template_branding(): void
    {
        $halaman = [
            $this->get(route('front.home')),
            $this->get('/login'),
            $this->actingAs(User::factory()->admin()->create())->get(route('adm.dashboard')),
            $this->actingAs(Agent::factory()->create()->hasUser)->get(route('agn.dashboard')),
        ];

        foreach ($halaman as $respons) {
            $respons->assertOk()
                ->assertSee('images/logo/', false)
                ->assertSee('favicon.svg', false)
                ->assertDontSee('real-estate/logo.png', false)
                ->assertDontSee('assets/images/logo-dark.png', false)
                ->assertDontSee('assets/images/favicon.ico', false);
        }
    }

    public function test_admin_and_agent_topbar_have_no_template_samples(): void
    {
        $admin = $this->actingAs(User::factory()->admin()->create())->get(route('adm.dashboard'));
        $agen = $this->actingAs(Agent::factory()->create()->hasUser)->get(route('agn.dashboard'));

        foreach ([$admin, $agen] as $respons) {
            $respons->assertDontSee('notificationDropdown', false)
                ->assertDontSee('app-search', false)
                ->assertDontSee('Anna Adame');
        }
    }

    public function test_themed_error_pages(): void
    {
        $this->get('/halaman-yang-tidak-ada')
            ->assertNotFound()
            ->assertSee('Halaman tidak ditemukan')
            ->assertSee('images/logo/logo-dark.svg', false);

        $this->actingAs(Agent::factory()->create()->hasUser)->get(route('adm.dashboard'))
            ->assertForbidden()
            ->assertSee('Akses ditolak');
    }

    public function test_property_detail_has_seo_and_share_preview_tags(): void
    {
        $property = Property::factory()->approved()->create([
            'name' => 'Kos Melati Dekat Kampus',
            'description' => 'Kamar bersih dan nyaman.',
            'harga_bulanan' => 1500000,
        ]);
        $property->gambars()->create(['name' => 'properties/x/foto.jpg', 'isDefault' => true]);

        $this->get(route('front.properties.detail', $property->slug))
            ->assertSee('<meta property="og:title" content="Kos Melati Dekat Kampus', false)
            ->assertSee('Mulai Rp 1.500.000 / Bulan', false)
            ->assertSee('<meta property="og:image" content="'.$property->gambarUtamaUrl().'"', false)
            ->assertSee('<link rel="canonical" href="'.route('front.properties.detail', $property->slug).'"', false);
    }

    public function test_sitemap_lists_only_public_pages_and_robots_blocks_private_areas(): void
    {
        $tayang = Property::factory()->approved()->create();
        $pending = Property::factory()->create();

        $this->get(route('front.sitemap'))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee(route('front.properties.detail', $tayang->slug), false)
            ->assertDontSee($pending->slug, false);

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /staff/')
            ->assertSee('Sitemap: '.route('front.sitemap'));
    }

    public function test_admin_can_reset_agent_and_user_passwords(): void
    {
        $admin = User::factory()->admin()->create();
        $agent = Agent::factory()->create();
        $user = User::factory()->create();
        $data = ['password' => 'sandi-baru-123', 'password_confirmation' => 'sandi-baru-123'];

        $this->actingAs($admin)->patch(route('adm.agent.password', $agent), $data)->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check('sandi-baru-123', $agent->hasUser->fresh()->password));

        $this->actingAs($admin)->patch(route('adm.user.password', $user), $data)->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check('sandi-baru-123', $user->fresh()->password));

        // Halaman pencari properti tidak bisa dipakai untuk mereset password admin/agen.
        $this->actingAs($admin)->patch(route('adm.user.password', $agent->hasUser), $data)->assertNotFound();

        $this->actingAs($admin)->patch(route('adm.user.password', $user), ['password' => 'pendek', 'password_confirmation' => 'pendek'])
            ->assertSessionHasErrors('password');
    }
}
