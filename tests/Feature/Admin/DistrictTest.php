<?php

namespace Tests\Feature\Admin;

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
            ->post(route('adm.disctrict.kabupaten.save'), [
                'provinsi_id' => base64_encode($provinsi->id),
                'name' => 'Kota Contoh',
            ])
            ->assertRedirect(route('adm.disctrict'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('kabupatens', ['provinsi_id' => $provinsi->id, 'name' => 'kota contoh']);
    }

    public function test_kabupaten_with_unknown_provinsi_is_rejected(): void
    {
        $this->actingAs($this->admin)
            ->post(route('adm.disctrict.kabupaten.save'), [
                'provinsi_id' => base64_encode('999'),
                'name' => 'Kota Contoh',
            ])
            ->assertSessionHasErrors('provinsi_id');

        $this->assertDatabaseCount('kabupatens', 0);
    }

    public function test_invalid_encoded_id_is_rejected(): void
    {
        $this->actingAs($this->admin)
            ->delete(route('adm.disctrict.kecamatan.delete'), [
                'kecamatan_id' => 'bukan-base64',
            ])
            ->assertSessionHasErrors('kecamatan_id');
    }

    public function test_admin_can_delete_kecamatan(): void
    {
        $kecamatan = Kecamatan::factory()->create();

        $this->actingAs($this->admin)
            ->delete(route('adm.disctrict.kecamatan.delete'), [
                'kecamatan_id' => base64_encode($kecamatan->id),
            ])
            ->assertSessionHasNoErrors();

        $this->assertSoftDeleted($kecamatan);
    }

    public function test_admin_can_update_provinsi(): void
    {
        $provinsi = Provinsi::factory()->create();

        $this->actingAs($this->admin)
            ->patch(route('adm.disctrict.provinsi.update'), [
                'provinsi_id' => base64_encode($provinsi->id),
                'name' => 'Provinsi Baru',
            ])
            ->assertSessionHasNoErrors();

        $this->assertSame('PROVINSI BARU', $provinsi->fresh()->name);
    }

    public function test_agen_can_not_manage_wilayah(): void
    {
        $this->actingAs(User::factory()->agen()->create())
            ->post(route('adm.disctrict.provinsi.save'), ['name' => 'X'])
            ->assertForbidden();

        $this->assertDatabaseCount('provinsis', 0);
    }
}
