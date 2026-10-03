<?php

namespace Tests\Feature\Agen;

use App\Models\Agent;
use App\Models\Gambar;
use App\Models\Kecamatan;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfilTest extends TestCase
{
    use RefreshDatabase;

    private Agent $agent;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake(Gambar::DISK);
        $this->agent = Agent::factory()->create(['gambar' => null, 'about' => null, 'kecamatan_id' => null]);
    }

    private function dataValid(array $override = []): array
    {
        return array_merge([
            'name' => 'Budi Agen',
            'phone' => '0812-3456-7890',
            'alamat' => 'Jl. Merdeka 1',
            'kecamatan' => Kecamatan::factory()->create()->id,
            'about' => 'Agen kos mahasiswa sejak 2015.',
        ], $override);
    }

    public function test_profile_page_and_incomplete_profile_reminder(): void
    {
        $user = $this->agent->hasUser;

        $this->actingAs($user)->get(route('agn.profil'))->assertOk()->assertSee('Profil Saya');
        $this->actingAs($user)->get(route('agn.dashboard'))
            ->assertSee('Lengkapi profil Anda')
            ->assertSee('foto profil, wilayah (kecamatan), deskripsi Tentang Saya');
    }

    public function test_agent_can_update_profile_with_photo_shown_publicly(): void
    {
        $user = $this->agent->hasUser;
        $data = $this->dataValid(['foto' => UploadedFile::fake()->image('saya.jpg', 600, 400)]);

        $this->actingAs($user)->patch(route('agn.profil.update'), $data)
            ->assertRedirect(route('agn.profil'))->assertSessionHasNoErrors();

        $this->agent->refresh();
        $this->assertSame('Budi Agen', $user->fresh()->name);
        $this->assertSame('0812-3456-7890', $this->agent->phone);
        $this->assertSame($data['kecamatan'], $this->agent->kecamatan_id);
        $this->assertSame('Agen kos mahasiswa sejak 2015.', $this->agent->about);
        Storage::disk(Gambar::DISK)->assertExists($this->agent->gambar);

        $this->actingAs($user)->get(route('agn.dashboard'))->assertDontSee('Lengkapi profil Anda');

        $this->post('/logout');
        $this->get(route('front.agents.detail', $this->agent))
            ->assertOk()
            ->assertSee('Budi Agen')
            ->assertSee('Agen kos mahasiswa sejak 2015.')
            ->assertSee($this->agent->fotoUrl(), false);
    }

    public function test_replacing_photo_deletes_old_file(): void
    {
        $user = $this->agent->hasUser;
        $this->actingAs($user)->patch(route('agn.profil.update'), $this->dataValid(['foto' => UploadedFile::fake()->image('lama.jpg')]));
        $lama = $this->agent->fresh()->gambar;

        $this->actingAs($user)->patch(route('agn.profil.update'), $this->dataValid(['foto' => UploadedFile::fake()->image('baru.png')]));
        $baru = $this->agent->fresh()->gambar;

        $this->assertNotSame($lama, $baru);
        Storage::disk(Gambar::DISK)->assertMissing($lama);
        Storage::disk(Gambar::DISK)->assertExists($baru);

        // Simpan tanpa foto baru: foto tetap.
        $this->actingAs($user)->patch(route('agn.profil.update'), $this->dataValid());
        $this->assertSame($baru, $this->agent->fresh()->gambar);
    }

    public function test_profile_validation(): void
    {
        $this->actingAs($this->agent->hasUser)->patch(route('agn.profil.update'), $this->dataValid([
            'name' => '',
            'phone' => 'bukan nomor',
            'kecamatan' => 999999,
            'foto' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
        ]))->assertSessionHasErrors(['name', 'phone', 'kecamatan', 'foto']);
    }

    public function test_change_email_requires_current_password(): void
    {
        $user = $this->agent->hasUser;
        $lain = User::factory()->create();

        $this->actingAs($user)->patch(route('agn.profil.email'), ['email' => 'baru@example.com', 'current_password' => 'salah'])
            ->assertSessionHasErrors('current_password');
        $this->actingAs($user)->patch(route('agn.profil.email'), ['email' => $lain->email, 'current_password' => 'password'])
            ->assertSessionHasErrors('email');

        $this->actingAs($user)->patch(route('agn.profil.email'), ['email' => 'baru@example.com', 'current_password' => 'password'])
            ->assertSessionHasNoErrors();
        $this->assertSame('baru@example.com', $user->fresh()->email);
    }

    public function test_agent_can_change_password_from_profile_page(): void
    {
        $user = $this->agent->hasUser;

        $this->actingAs($user)->from(route('agn.profil'))->put(route('password.update'), [
            'current_password' => 'password',
            'password' => 'password-baru-1',
            'password_confirmation' => 'password-baru-1',
        ])->assertRedirect(route('agn.profil'));

        $this->assertTrue(Hash::check('password-baru-1', $user->fresh()->password));
    }

    public function test_topbar_shows_agent_name_and_profile_link(): void
    {
        $this->agent->hasUser->update(['name' => 'Sinta Agen']);

        $this->actingAs($this->agent->hasUser)->get(route('agn.dashboard'))
            ->assertSee('Sinta Agen')
            ->assertSee(route('agn.profil'), false)
            ->assertDontSee('Anna Adame');
    }

    public function test_non_agents_cannot_open_agent_profile(): void
    {
        $this->actingAs(User::factory()->create())->get(route('agn.profil'))->assertForbidden();
        $this->actingAs(User::factory()->admin()->create())->patch(route('agn.profil.update'), $this->dataValid())->assertForbidden();
    }
}
