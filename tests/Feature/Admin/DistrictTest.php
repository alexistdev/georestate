<?php

namespace Tests\Feature\Admin;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DistrictTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_add_kabupaten_to_existing_provinsi(): void
    {
        $provinsi = Provinsi::factory()->create();

        $this->actingAs($this->admin)
            ->post(route('adm.wilayah.kabupaten.save'), [
                'provinsi_id' => $provinsi->id,
                'name' => 'Kota Contoh',
            ])
            ->assertRedirect(route('adm.wilayah'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('kabupatens', ['provinsi_id' => $provinsi->id, 'name' => 'kota contoh']);
    }

    public function test_kabupaten_with_unknown_provinsi_is_rejected(): void
    {
        $this->actingAs($this->admin)
            ->post(route('adm.wilayah.kabupaten.save'), [
                'provinsi_id' => 999,
                'name' => 'Kota Contoh',
            ])
            ->assertSessionHasErrors('provinsi_id');

        $this->assertDatabaseCount('kabupatens', 0);
    }

    public function test_invalid_id_is_rejected(): void
    {
        $this->actingAs($this->admin)
            ->delete(route('adm.wilayah.kecamatan.delete'), [
                'kecamatan_id' => 'bukan-angka',
            ])
            ->assertSessionHasErrors('kecamatan_id');
    }

    public function test_admin_can_delete_kecamatan(): void
    {
        $kecamatan = Kecamatan::factory()->create();

        $this->actingAs($this->admin)
            ->delete(route('adm.wilayah.kecamatan.delete'), [
                'kecamatan_id' => $kecamatan->id,
            ])
            ->assertSessionHasNoErrors();

        $this->assertSoftDeleted($kecamatan);
    }

    public function test_admin_can_update_provinsi(): void
    {
        $provinsi = Provinsi::factory()->create();

        $this->actingAs($this->admin)
            ->patch(route('adm.wilayah.provinsi.update'), [
                'provinsi_id' => $provinsi->id,
                'name' => 'Provinsi Baru',
            ])
            ->assertSessionHasNoErrors();

        $this->assertSame('PROVINSI BARU', $provinsi->fresh()->name);
    }

    public function test_agen_can_not_manage_wilayah(): void
    {
        $this->actingAs(User::factory()->agen()->create())
            ->post(route('adm.wilayah.provinsi.save'), ['name' => 'X'])
            ->assertForbidden();

        $this->assertDatabaseCount('provinsis', 0);
    }

    public function test_region_tables_are_paged_on_the_server(): void
    {
        $kabupaten = Kabupaten::factory()->create(['name' => 'Kota Contoh']);
        Kecamatan::factory()->count(30)->create(['kabupaten_id' => $kabupaten->id]);
        Kecamatan::factory()->create(['kabupaten_id' => $kabupaten->id, 'name' => 'Kecamatan Melati']);
        $ajax = ['X-Requested-With' => 'XMLHttpRequest'];
        $kolom = [
            ['data' => 'DT_RowIndex', 'searchable' => 'false', 'orderable' => 'false'],
            ['data' => 'name', 'name' => 'name', 'searchable' => 'true', 'orderable' => 'true'],
            ['data' => 'kabupaten.name', 'name' => 'kabupaten.name', 'searchable' => 'true', 'orderable' => 'true'],
            ['data' => 'action', 'searchable' => 'false', 'orderable' => 'false'],
        ];

        $halaman = $this->actingAs($this->admin)->getJson(route('adm.ajax.kecamatan', [
            'draw' => 1, 'start' => 0, 'length' => 10, 'columns' => $kolom,
            'order' => [['column' => 1, 'dir' => 'asc']], 'search' => ['value' => ''],
        ]), $ajax)->assertOk();

        $this->assertSame(31, $halaman->json('recordsTotal'));
        $this->assertCount(10, $halaman->json('data'));
        $this->assertSame('KOTA CONTOH', $halaman->json('data.0.kabupaten.name'));

        $cari = $this->actingAs($this->admin)->getJson(route('adm.ajax.kecamatan', [
            'draw' => 2, 'start' => 0, 'length' => 10, 'columns' => $kolom,
            'order' => [['column' => 1, 'dir' => 'asc']], 'search' => ['value' => 'melati'],
        ]), $ajax)->assertOk();

        $this->assertSame(1, $cari->json('recordsFiltered'));
        $this->assertStringContainsString('data-kabupaten="'.$kabupaten->id.'"', $cari->json('data.0.action'));

        // Hanya bisa diakses lewat AJAX.
        $this->actingAs($this->admin)->get(route('adm.ajax.kecamatan'))->assertNotFound();
    }

    public function test_agen_form_region_dropdown_uses_plain_ids(): void
    {
        $provinsi = Provinsi::factory()->create();
        $kabupaten = Kabupaten::factory()->create(['provinsi_id' => $provinsi->id]);

        $this->getJson(route('front.wilayah.kabupaten', $provinsi->id))
            ->assertOk()
            ->assertJsonPath('0.id', $kabupaten->id);
    }

    public function test_region_page_uses_plain_ids_in_forms(): void
    {
        $provinsi = Provinsi::factory()->create(['name' => 'Lampung']);

        $this->actingAs($this->admin)->get(route('adm.wilayah'))
            ->assertOk()
            ->assertSee('<option value="'.$provinsi->id.'"', false)
            ->assertSee('serverSide: true', false)
            ->assertDontSee(base64_encode((string) $provinsi->id).'"', false);
    }
}
