<?php

namespace Tests\Feature\Front;

use App\Models\Agent;
use App\Models\Fasilitas;
use App\Models\Kabupaten;
use App\Models\Kategori;
use App\Models\Kecamatan;
use App\Models\Property;
use App\Models\Provinsi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPropertyTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_only_shows_approved_listings(): void
    {
        Property::factory()->approved()->create(['name' => 'Listing Tayang']);
        Property::factory()->create(['name' => 'Listing Pending']);
        Property::factory()->rejected()->create(['name' => 'Listing Ditolak']);

        $this->get(route('front.home'))
            ->assertOk()
            ->assertSee('Listing Tayang')
            ->assertDontSee('Listing Pending')
            ->assertDontSee('Listing Ditolak');
    }

    public function test_listings_of_suspended_agent_are_hidden(): void
    {
        $agent = Agent::factory()->create(['isSuspend' => true]);
        $property = Property::factory()->approved()->for($agent)->create(['name' => 'Listing Agen Suspend']);

        $this->get(route('front.properties'))->assertOk()->assertDontSee('Listing Agen Suspend');
        $this->get(route('front.properties.detail', $property->slug))->assertNotFound();
        $this->get(route('front.agents.detail', $agent))->assertNotFound();
    }

    public function test_detail_page_shows_listing_and_agent_contact(): void
    {
        $agent = Agent::factory()->create(['phone' => '0812-3456-7890']);
        $property = Property::factory()->approved()->for($agent)->create([
            'name' => 'Kos Melati',
            'harga_harian' => 75000,
            'harga_bulanan' => 1500000,
        ]);
        $property->fasilitas()->attach(Fasilitas::factory()->create(['name' => 'Water Heater']));

        $this->get(route('front.properties.detail', $property->slug))
            ->assertOk()
            ->assertSee('Kos Melati')
            ->assertSeeInOrder(['Sewa / Hari', 'Rp 75.000', 'Sewa / Bulan', 'Rp 1.500.000'])
            ->assertSee('Water Heater')
            ->assertSee('https://wa.me/6281234567890', false)
            ->assertSee('petaLokasi', false);
    }

    public function test_detail_page_of_unapproved_listing_is_not_found(): void
    {
        $pending = Property::factory()->create();

        $this->get(route('front.properties.detail', $pending->slug))->assertNotFound();
        $this->get(route('front.properties.detail', 'slug-tidak-ada'))->assertNotFound();
    }

    public function test_filter_by_kategori_and_keyword(): void
    {
        $kos = Kategori::factory()->create(['name' => 'kos']);
        $ruko = Kategori::factory()->create(['name' => 'ruko']);
        Property::factory()->approved()->for($kos)->create(['name' => 'Kos Mawar']);
        Property::factory()->approved()->for($ruko)->create(['name' => 'Ruko Melati']);

        $this->get(route('front.properties', ['kategori' => $kos->id]))
            ->assertSee('Kos Mawar')->assertDontSee('Ruko Melati');

        $this->get(route('front.properties', ['q' => 'melati']))
            ->assertSee('Ruko Melati')->assertDontSee('Kos Mawar');
    }

    public function test_filter_by_wilayah(): void
    {
        $provinsi = Provinsi::factory()->create();
        $kabupaten = Kabupaten::factory()->for($provinsi)->create();
        $kecamatanA = Kecamatan::factory()->for($kabupaten)->create();
        $kecamatanB = Kecamatan::factory()->for($kabupaten)->create();

        Property::factory()->approved()->create(['name' => 'Di Kecamatan A', 'kecamatan_id' => $kecamatanA->id]);
        Property::factory()->approved()->create(['name' => 'Di Kecamatan B', 'kecamatan_id' => $kecamatanB->id]);
        Property::factory()->approved()->create(['name' => 'Di Provinsi Lain']);

        $this->get(route('front.properties', ['provinsi' => $provinsi->id]))
            ->assertSee('Di Kecamatan A')->assertSee('Di Kecamatan B')->assertDontSee('Di Provinsi Lain');

        $this->get(route('front.properties', ['provinsi' => $provinsi->id, 'kabupaten' => $kabupaten->id, 'kecamatan' => $kecamatanA->id]))
            ->assertSee('Di Kecamatan A')->assertDontSee('Di Kecamatan B');
    }

    public function test_filter_by_periode_and_price_and_sort(): void
    {
        Property::factory()->approved()->create(['name' => 'Harian Saja', 'harga_harian' => 100000, 'harga_bulanan' => null]);
        Property::factory()->approved()->create(['name' => 'Bulanan Murah', 'harga_bulanan' => 800000]);
        Property::factory()->approved()->create(['name' => 'Bulanan Mahal', 'harga_bulanan' => 5000000]);

        $this->get(route('front.properties', ['periode' => 'harian']))
            ->assertSee('Harian Saja')->assertDontSee('Bulanan Murah');

        $this->get(route('front.properties', ['periode' => 'bulanan', 'harga_max' => 1000000]))
            ->assertSee('Bulanan Murah')->assertDontSee('Bulanan Mahal')->assertDontSee('Harian Saja');

        $this->get(route('front.properties', ['periode' => 'bulanan', 'urut' => 'termahal']))
            ->assertSeeInOrder(['Bulanan Mahal', 'Bulanan Murah']);
    }

    public function test_card_shows_price_of_filtered_period(): void
    {
        Property::factory()->approved()->create(['harga_harian' => 85000, 'harga_bulanan' => 1250000]);

        $this->get(route('front.properties'))
            ->assertSee('Rp 1.250.000')->assertDontSee('Rp 85.000');

        $this->get(route('front.properties', ['periode' => 'harian']))
            ->assertSee('Rp 85.000')->assertDontSee('Rp 1.250.000');
    }

    public function test_listing_without_photo_uses_default_image(): void
    {
        $property = Property::factory()->approved()->create();
        $default = asset(\App\Models\Gambar::DEFAULT);

        $this->assertFileExists(public_path(\App\Models\Gambar::DEFAULT));

        $this->get(route('front.properties'))->assertSee('src="'.$default.'"', false);
        $this->get(route('front.properties.detail', $property->slug))->assertSee('src="'.$default.'"', false);
    }

    public function test_photos_fall_back_to_default_image_when_file_is_missing(): void
    {
        $property = Property::factory()->approved()->create();
        $property->gambars()->create(['name' => 'properties/tidak-ada.jpg', 'isDefault' => true]);

        $this->get(route('front.properties.detail', $property->slug))
            ->assertSee("this.src='".asset(\App\Models\Gambar::DEFAULT)."'", false)
            ->assertSee("this.src='".asset(\App\Models\Agent::FOTO_DEFAULT)."'", false);
    }

    public function test_invalid_filter_values_are_ignored(): void
    {
        Property::factory()->approved()->create(['name' => 'Tetap Tampil']);

        $this->get('/properties?kategori=abc&periode=mingguan&urut=acak&harga_min=-5&q[]=x')
            ->assertOk()
            ->assertSee('Tetap Tampil');
    }

    public function test_wilayah_ajax_endpoints(): void
    {
        $provinsi = Provinsi::factory()->create();
        $kabupaten = Kabupaten::factory()->for($provinsi)->create(['name' => 'Kota Contoh']);
        Kecamatan::factory()->for($kabupaten)->create(['name' => 'Kecamatan Contoh']);

        $this->getJson(route('front.wilayah.kabupaten', $provinsi->id))
            ->assertOk()->assertJsonFragment(['name' => 'KOTA CONTOH']);
        $this->getJson(route('front.wilayah.kecamatan', $kabupaten->id))
            ->assertOk()->assertJsonFragment(['name' => 'KECAMATAN CONTOH']);
    }

    public function test_agent_pages(): void
    {
        $agent = Agent::factory()->create();
        Property::factory()->approved()->for($agent)->create(['name' => 'Listing Milik Agen']);
        Property::factory()->for($agent)->create(['name' => 'Listing Pending Agen']);

        $this->get(route('front.agents'))->assertOk()->assertSee($agent->hasUser->name);

        $this->get(route('front.agents.detail', $agent))
            ->assertOk()
            ->assertSee('Listing Milik Agen')
            ->assertDontSee('Listing Pending Agen');
    }

    public function test_static_pages_render(): void
    {
        $this->get(route('front.about'))->assertOk();
        $this->get(route('front.contact'))->assertOk();
    }
}
