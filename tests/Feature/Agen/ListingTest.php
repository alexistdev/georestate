<?php

namespace Tests\Feature\Agen;

use App\Enums\PropertyStatus;
use App\Models\Agent;
use App\Models\Fasilitas;
use App\Models\Gambar;
use App\Models\Kategori;
use App\Models\Kecamatan;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ListingTest extends TestCase
{
    use RefreshDatabase;

    private Agent $agent;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake(Gambar::DISK);

        $this->agent = Agent::factory()->create();
        $this->user = $this->agent->hasUser;
    }

    private function dataValid(array $override = []): array
    {
        return array_merge([
            'name' => 'Kos Putri Dekat Kampus',
            'description' => 'Kos nyaman',
            'kategori' => Kategori::factory()->create()->id,
            'lt' => 4,
            'lb' => 3,
            'kamar_tidur' => 1,
            'kamar_mandi' => 1,
            'harga_bulanan' => 1500000,
            'kecamatan' => Kecamatan::factory()->create()->id,
            'address' => 'Jl. Contoh No. 1',
            'gambar' => [
                UploadedFile::fake()->image('depan.jpg'),
                UploadedFile::fake()->image('kamar.png'),
            ],
        ], $override);
    }

    private function buatListing(array $state = []): Property
    {
        $property = Property::factory()->for($this->agent)->create($state);
        $property->gambars()->create(['name' => 'properties/'.$property->id.'/a.jpg', 'isDefault' => true]);
        $property->gambars()->create(['name' => 'properties/'.$property->id.'/b.jpg', 'isDefault' => false]);

        return $property;
    }

    public function test_agen_can_create_listing_with_photos_and_fasilitas(): void
    {
        $fasilitas = Fasilitas::factory()->count(3)->create();

        $response = $this->actingAs($this->user)->post(route('agn.lists.save'), $this->dataValid([
            'harga_harian' => 100000,
            'fasilitas' => $fasilitas->take(2)->pluck('id')->all(),
        ]));

        $property = Property::first();
        $response->assertRedirect(route('agn.lists.show', $property));

        $this->assertSame($this->agent->id, $property->agent_id);
        $this->assertSame(PropertyStatus::Pending, $property->status);
        $this->assertSame(100000, $property->harga_harian);
        $this->assertSame(1500000, $property->harga_bulanan);
        $this->assertNull($property->harga_tahunan);
        $this->assertNotEmpty($property->slug);
        $this->assertCount(2, $property->fasilitas);

        $this->assertCount(2, $property->gambars);
        $this->assertSame(1, $property->gambars->where('isDefault', true)->count());
        foreach ($property->gambars as $gambar) {
            Storage::disk(Gambar::DISK)->assertExists($gambar->name);
        }
    }

    public function test_at_least_one_price_is_required(): void
    {
        $this->actingAs($this->user)
            ->post(route('agn.lists.save'), $this->dataValid(['harga_bulanan' => null]))
            ->assertSessionHasErrors(['harga_harian', 'harga_bulanan', 'harga_tahunan']);

        $this->assertDatabaseCount('properties', 0);
    }

    public function test_photo_is_required_and_validated(): void
    {
        $this->actingAs($this->user)
            ->post(route('agn.lists.save'), $this->dataValid(['gambar' => []]))
            ->assertSessionHasErrors('gambar');

        $this->actingAs($this->user)
            ->post(route('agn.lists.save'), $this->dataValid([
                'gambar' => [UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf')],
            ]))
            ->assertSessionHasErrors('gambar.0');

        $this->actingAs($this->user)
            ->post(route('agn.lists.save'), $this->dataValid([
                'gambar' => [UploadedFile::fake()->image('besar.jpg')->size(3000)],
            ]))
            ->assertSessionHasErrors('gambar.0');

        $this->actingAs($this->user)
            ->post(route('agn.lists.save'), $this->dataValid([
                'gambar' => array_map(fn ($i) => UploadedFile::fake()->image("f$i.jpg"), range(1, 11)),
            ]))
            ->assertSessionHasErrors('gambar');

        $this->assertDatabaseCount('properties', 0);
    }

    public function test_agen_only_sees_own_listings(): void
    {
        $milikSendiri = $this->buatListing(['name' => 'Listing Saya']);
        Property::factory()->create(['name' => 'Listing Agen Lain']);

        $this->actingAs($this->user)->get(route('agn.lists'))
            ->assertOk()
            ->assertSee('Listing Saya')
            ->assertDontSee('Listing Agen Lain');

        $this->actingAs($this->user)->get(route('agn.lists.show', $milikSendiri))->assertOk();
    }

    public function test_agen_can_not_access_other_agents_listing(): void
    {
        $milikLain = Property::factory()->create();

        $this->actingAs($this->user)->get(route('agn.lists.show', $milikLain))->assertForbidden();
        $this->actingAs($this->user)->get(route('agn.lists.edit', $milikLain))->assertForbidden();
        $this->actingAs($this->user)
            ->patch(route('agn.lists.update', $milikLain), $this->dataValid(['gambar' => []]))
            ->assertForbidden();
        $this->actingAs($this->user)->delete(route('agn.lists.delete', $milikLain))->assertForbidden();

        $this->assertNotSoftDeleted($milikLain);
    }

    public function test_create_and_detail_pages_render(): void
    {
        Fasilitas::factory()->create(['name' => 'Water Heater']);
        $this->actingAs($this->user)->get(route('agn.lists.add'))
            ->assertOk()
            ->assertSee('Water Heater');

        $property = $this->buatListing(['harga_bulanan' => 1500000, 'harga_harian' => 75000]);
        $property->forceFill(['status' => PropertyStatus::Rejected, 'alasan_penolakan' => 'Foto buram'])->save();

        $this->actingAs($this->user)->get(route('agn.lists.show', $property))
            ->assertOk()
            ->assertSee('Ditolak')
            ->assertSee('Foto buram')
            ->assertSeeInOrder(['Per Hari', 'Rp 75.000', 'Per Bulan', 'Rp 1.500.000']);
    }

    public function test_edit_page_renders(): void
    {
        $property = $this->buatListing();

        $this->actingAs($this->user)->get(route('agn.lists.edit', $property))
            ->assertOk()
            ->assertSee($property->name);
    }

    public function test_updating_approved_listing_returns_it_to_pending(): void
    {
        $property = $this->buatListing();
        $property->forceFill(['status' => PropertyStatus::Approved, 'approved_at' => now()])->save();
        $fasilitas = Fasilitas::factory()->create();

        $this->actingAs($this->user)
            ->patch(route('agn.lists.update', $property), $this->dataValid([
                'name' => 'Nama Baru',
                'harga_bulanan' => null,
                'harga_tahunan' => 15000000,
                'fasilitas' => [$fasilitas->id],
                'gambar' => [UploadedFile::fake()->image('baru.jpg')],
            ]))
            ->assertRedirect(route('agn.lists.show', $property))
            ->assertSessionHasNoErrors();

        $property->refresh();
        $this->assertSame('Nama Baru', $property->name);
        $this->assertSame(PropertyStatus::Pending, $property->status);
        $this->assertNull($property->approved_at);
        $this->assertNull($property->harga_bulanan);
        $this->assertSame(15000000, $property->harga_tahunan);
        $this->assertSame([$fasilitas->id], $property->fasilitas->pluck('id')->all());
        $this->assertCount(3, $property->gambars);
        $this->assertSame(1, $property->gambars->where('isDefault', true)->count());
    }

    public function test_update_can_not_exceed_photo_limit(): void
    {
        $property = $this->buatListing(); // sudah 2 foto

        $this->actingAs($this->user)
            ->patch(route('agn.lists.update', $property), $this->dataValid([
                'gambar' => array_map(fn ($i) => UploadedFile::fake()->image("f$i.jpg"), range(1, 9)),
            ]))
            ->assertSessionHasErrors('gambar');

        $this->assertCount(2, $property->gambars()->get());
    }

    public function test_agen_can_delete_listing(): void
    {
        $property = $this->buatListing();

        $this->actingAs($this->user)
            ->delete(route('agn.lists.delete', $property))
            ->assertRedirect(route('agn.lists'));

        $this->assertSoftDeleted($property);
    }

    public function test_agen_can_change_main_photo_and_delete_photo(): void
    {
        $property = $this->buatListing();
        [$utama, $lain] = $property->gambars()->get()->all();
        Storage::disk(Gambar::DISK)->put($utama->name, 'x');

        $this->actingAs($this->user)
            ->patch(route('agn.lists.gambar.utama', [$property, $lain]))
            ->assertSessionHasNoErrors();
        $this->assertTrue($lain->fresh()->isDefault);
        $this->assertFalse($utama->fresh()->isDefault);

        $this->actingAs($this->user)
            ->delete(route('agn.lists.gambar.delete', [$property, $utama]))
            ->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('gambars', ['id' => $utama->id]);
        Storage::disk(Gambar::DISK)->assertMissing($utama->name);
    }

    public function test_deleting_main_photo_promotes_another(): void
    {
        $property = $this->buatListing();
        [$utama, $lain] = $property->gambars()->get()->all();

        $this->actingAs($this->user)->delete(route('agn.lists.gambar.delete', [$property, $utama]));

        $this->assertTrue($lain->fresh()->isDefault);
    }

    public function test_last_photo_can_not_be_deleted(): void
    {
        $property = Property::factory()->for($this->agent)->create();
        $gambar = $property->gambars()->create(['name' => 'properties/x.jpg', 'isDefault' => true]);

        $this->actingAs($this->user)
            ->delete(route('agn.lists.gambar.delete', [$property, $gambar]))
            ->assertSessionHasErrors('foto');

        $this->assertDatabaseHas('gambars', ['id' => $gambar->id]);
    }

    public function test_photo_must_belong_to_listing(): void
    {
        $property = $this->buatListing();
        $fotoListingLain = $this->buatListing()->gambars()->first();

        $this->actingAs($this->user)
            ->delete(route('agn.lists.gambar.delete', [$property, $fotoListingLain]))
            ->assertNotFound();
    }
}
