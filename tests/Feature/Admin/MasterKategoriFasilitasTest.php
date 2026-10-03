<?php

namespace Tests\Feature\Admin;

use App\Models\Agent;
use App\Models\Fasilitas;
use App\Models\Gambar;
use App\Models\Kategori;
use App\Models\Kecamatan;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MasterKategoriFasilitasTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_add_rename_and_list_kategori_with_usage_count(): void
    {
        $this->actingAs($this->admin)->post(route('adm.kategori.save'), ['name' => '  Kos   Putri '])
            ->assertRedirect(route('adm.kategori'))->assertSessionHasNoErrors();

        $kategori = Kategori::where('name', 'Kos Putri')->firstOrFail();
        Property::factory()->count(2)->for($kategori)->create();

        $this->actingAs($this->admin)->patch(route('adm.kategori.update', $kategori->id), ['name' => 'Kos'])
            ->assertSessionHasNoErrors();
        $this->assertSame('Kos', $kategori->fresh()->name);

        $this->actingAs($this->admin)->get(route('adm.kategori'))
            ->assertOk()
            ->assertSeeInOrder(['Kos', '2']);
    }

    public function test_kategori_name_must_be_unique_case_insensitive(): void
    {
        $rumah = Kategori::factory()->create(['name' => 'Rumah']);
        $ruko = Kategori::factory()->create(['name' => 'Ruko']);

        $this->actingAs($this->admin)->post(route('adm.kategori.save'), ['name' => 'rumah'])
            ->assertSessionHasErrors('name');
        $this->actingAs($this->admin)->patch(route('adm.kategori.update', $ruko->id), ['name' => 'RUMAH'])
            ->assertSessionHasErrors('name');

        // Mengubah huruf besar/kecil nama sendiri tetap boleh.
        $this->actingAs($this->admin)->patch(route('adm.kategori.update', $rumah->id), ['name' => 'rumah'])
            ->assertSessionHasNoErrors();
    }

    public function test_deleted_kategori_still_shown_on_old_listing_but_not_selectable(): void
    {
        $kategori = Kategori::factory()->create(['name' => 'Gudang']);
        $property = Property::factory()->approved()->for($kategori)->create();

        $this->actingAs($this->admin)->delete(route('adm.kategori.delete', $kategori->id))
            ->assertRedirect(route('adm.kategori'));
        $this->assertSoftDeleted($kategori);

        // Listing lama tetap menampilkan kategorinya.
        $this->get(route('front.properties.detail', $property->slug))->assertOk()->assertSee('Gudang');

        // Tidak muncul lagi di filter pencarian & form agen.
        $this->get(route('front.properties'))->assertDontSee('>Gudang</option>', false);
        $agen = Agent::factory()->create()->hasUser;
        $this->actingAs($agen)->get(route('agn.lists.add'))->assertDontSee('>Gudang</option>', false);
    }

    public function test_agent_must_choose_another_kategori_when_editing_listing_with_deleted_kategori(): void
    {
        Storage::fake(Gambar::DISK);
        $agent = Agent::factory()->create();
        $lama = Kategori::factory()->create(['name' => 'Villa']);
        $property = Property::factory()->for($agent)->for($lama)->create();
        $lama->delete();

        $this->actingAs($agent->hasUser)->get(route('agn.lists.edit', $property))
            ->assertOk()->assertSee('Kategori sebelumnya (Villa) sudah dihapus admin');

        $data = [
            'name' => $property->name, 'lt' => 10, 'lb' => 10, 'harga_bulanan' => 1000000,
            'kecamatan' => Kecamatan::factory()->create()->id, 'kategori' => $lama->id,
        ];
        $this->actingAs($agent->hasUser)->patch(route('agn.lists.update', $property), $data)
            ->assertSessionHasErrors(['kategori' => 'Kategori sudah tidak tersedia, silahkan pilih kategori lain!']);

        $baru = Kategori::factory()->create();
        $this->actingAs($agent->hasUser)->patch(route('agn.lists.update', $property), array_merge($data, ['kategori' => $baru->id]))
            ->assertSessionHasNoErrors();
        $this->assertSame($baru->id, $property->fresh()->kategori_id);
    }

    public function test_deleted_fasilitas_shown_on_old_listing_and_detached_on_next_save(): void
    {
        Storage::fake(Gambar::DISK);
        $agent = Agent::factory()->create();
        $hapus = Fasilitas::factory()->create(['name' => 'Sauna']);
        $tetap = Fasilitas::factory()->create(['name' => 'WiFi Cepat']);
        $property = Property::factory()->approved()->for($agent)->create();
        $property->fasilitas()->sync([$hapus->id, $tetap->id]);

        $this->actingAs($this->admin)->delete(route('adm.fasilitas.delete', $hapus->id));

        $this->get(route('front.properties.detail', $property->slug))->assertSee('Sauna');
        $this->actingAs($agent->hasUser)->get(route('agn.lists.edit', $property))->assertDontSee('Sauna');

        $this->actingAs($agent->hasUser)->patch(route('agn.lists.update', $property), [
            'name' => $property->name, 'lt' => 10, 'lb' => 10, 'harga_bulanan' => 1000000,
            'kecamatan' => $property->kecamatan_id, 'kategori' => $property->kategori_id,
            'fasilitas' => [$tetap->id],
        ])->assertSessionHasNoErrors();

        $this->assertSame([$tetap->id], $property->fresh()->fasilitas->pluck('id')->all());
    }

    public function test_restore_and_restore_conflict(): void
    {
        $fasilitas = Fasilitas::factory()->create(['name' => 'Balkon']);
        $fasilitas->delete();

        $this->actingAs($this->admin)->get(route('adm.fasilitas', ['tab' => 'terhapus']))->assertSee('Balkon');

        Fasilitas::factory()->create(['name' => 'balkon']);
        $this->actingAs($this->admin)->patch(route('adm.fasilitas.restore', $fasilitas->id))
            ->assertSessionHasErrors('name');
        $this->assertSoftDeleted($fasilitas);

        Fasilitas::where('name', 'balkon')->delete();
        $this->actingAs($this->admin)->patch(route('adm.fasilitas.restore', $fasilitas->id))
            ->assertSessionHasNoErrors();
        $this->assertNotSoftDeleted($fasilitas);
    }

    public function test_migration_normalizes_old_lowercase_kategori_names(): void
    {
        \Illuminate\Support\Facades\DB::table('kategoris')->insert([
            ['name' => 'apartement', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'rumah susun', 'created_at' => now(), 'updated_at' => now()],
        ]);

        (require database_path('migrations/2026_10_06_000001_normalize_kategori_names.php'))->up();

        $this->assertSame(['Apartemen', 'Rumah Susun'], Kategori::orderBy('id')->pluck('name')->all());
    }

    public function test_agent_cannot_manage_master_data(): void
    {
        $agen = Agent::factory()->create()->hasUser;

        $this->actingAs($agen)->get(route('adm.kategori'))->assertForbidden();
        $this->actingAs($agen)->post(route('adm.fasilitas.save'), ['name' => 'Hack'])->assertForbidden();
        $this->assertDatabaseMissing('fasilitas', ['name' => 'Hack']);
    }
}
