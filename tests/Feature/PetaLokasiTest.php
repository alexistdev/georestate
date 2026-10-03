<?php

namespace Tests\Feature;

use App\Models\Agent;
use App\Models\Gambar;
use App\Models\Kategori;
use App\Models\Kecamatan;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Fase 6C: titik lokasi listing (Leaflet + OpenStreetMap).
 */
class PetaLokasiTest extends TestCase
{
    use RefreshDatabase;

    private Agent $agent;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake(Gambar::DISK);
        $this->agent = Agent::factory()->create();
    }

    private function dataListing(array $override = []): array
    {
        return array_merge([
            'name' => 'Kos Dekat Kampus',
            'kategori' => Kategori::factory()->create()->id,
            'lt' => 4,
            'lb' => 3,
            'harga_bulanan' => 1500000,
            'kecamatan' => Kecamatan::factory()->create()->id,
            'gambar' => [UploadedFile::fake()->image('depan.jpg')],
        ], $override);
    }

    public function test_agen_can_save_and_clear_location_point(): void
    {
        $this->actingAs($this->agent->hasUser)
            ->post(route('agn.lists.save'), $this->dataListing(['latitude' => '-5.3971396', 'longitude' => '105.2667887']))
            ->assertSessionHasNoErrors();

        $property = Property::firstOrFail();
        $this->assertSame(-5.3971396, $property->latitude);
        $this->assertSame(105.2667887, $property->longitude);

        $this->actingAs($this->agent->hasUser)
            ->patch(route('agn.lists.update', $property), $this->dataListing(['latitude' => '', 'longitude' => '', 'gambar' => []]))
            ->assertSessionHasNoErrors();

        $this->assertFalse($property->fresh()->punyaKoordinat());
    }

    public function test_location_point_must_be_complete_and_inside_indonesia(): void
    {
        $this->actingAs($this->agent->hasUser)
            ->post(route('agn.lists.save'), $this->dataListing(['latitude' => '-5.39']))
            ->assertSessionHasErrors('longitude');

        // Titik di Eropa ditolak.
        $this->actingAs($this->agent->hasUser)
            ->post(route('agn.lists.save'), $this->dataListing(['latitude' => '48.85', 'longitude' => '2.35']))
            ->assertSessionHasErrors(['latitude', 'longitude']);

        $this->actingAs($this->agent->hasUser)
            ->post(route('agn.lists.save'), $this->dataListing(['latitude' => 'abc', 'longitude' => '105']))
            ->assertSessionHasErrors('latitude');

        $this->assertDatabaseCount('properties', 0);
    }

    public function test_listing_form_has_map_picker(): void
    {
        $this->actingAs($this->agent->hasUser)->get(route('agn.lists.add'))
            ->assertOk()
            ->assertSee('id="petaPilihLokasi"', false)
            ->assertSee('name="latitude"', false)
            ->assertSee('leaflet/1.9.4/leaflet.js', false);
    }

    public function test_detail_page_shows_map_only_when_point_is_set(): void
    {
        $denganTitik = Property::factory()->approved()->create(['latitude' => -6.2, 'longitude' => 106.816666]);
        $tanpaTitik = Property::factory()->approved()->create();

        $this->get(route('front.properties.detail', $denganTitik->slug))
            ->assertOk()
            ->assertSee('data-lat="-6.2"', false)
            ->assertSee('data-lng="106.816666"', false)
            ->assertSee('leaflet/1.9.4/leaflet.js', false)
            ->assertSee('google.com/maps/dir/?api=1&amp;destination=-6.2,106.816666', false);

        $this->get(route('front.properties.detail', $tanpaTitik->slug))
            ->assertOk()
            ->assertSee('Agen belum menandai titik lokasi')
            ->assertDontSee('leaflet.js', false);
    }

    public function test_agent_and_admin_listing_detail_show_map(): void
    {
        $property = Property::factory()->for($this->agent)->create(['latitude' => -7.25, 'longitude' => 112.75]);

        $this->actingAs($this->agent->hasUser)->get(route('agn.lists.show', $property))
            ->assertOk()
            ->assertSee('data-lat="-7.25"', false);

        $this->actingAs(User::factory()->admin()->create())->get(route('adm.listing.show', $property))
            ->assertOk()
            ->assertSee('data-lat="-7.25"', false);
    }
}
