<?php

namespace Tests\Feature\Super;

use App\Enums\Role;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class KelolaAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $super;

    protected function setUp(): void
    {
        parent::setUp();
        $this->super = User::factory()->super()->create();
    }

    public function test_super_dashboard_shows_admin_count_and_super_menu(): void
    {
        User::factory()->admin()->count(2)->create();

        $this->actingAs($this->super)->get(route('sup.dashboard'))
            ->assertOk()
            ->assertSeeInOrder(['Akun Admin', '2'])
            ->assertSee('Kelola Admin');

        // Admin biasa tidak melihat kartu & menu khusus super.
        $this->actingAs(User::factory()->admin()->create())->get(route('adm.dashboard'))
            ->assertOk()
            ->assertDontSee('Akun Admin')
            ->assertDontSee('Kelola Admin');
    }

    public function test_super_can_create_admin_who_can_login(): void
    {
        $this->actingAs($this->super)->post(route('sup.admin.save'), [
            'name' => 'Admin Baru',
            'email' => 'adminbaru@example.com',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ])->assertRedirect(route('sup.admin'))->assertSessionHasNoErrors();

        $admin = User::where('email', 'adminbaru@example.com')->firstOrFail();
        $this->assertSame(Role::Admin, $admin->roleEnum());

        $this->post('/logout');
        $this->post('/login', ['email' => 'adminbaru@example.com', 'password' => 'rahasia123'])
            ->assertRedirect(route('adm.dashboard'));
    }

    public function test_create_admin_validation(): void
    {
        $agen = Agent::factory()->create()->hasUser;

        $this->actingAs($this->super)->post(route('sup.admin.save'), [
            'name' => '', 'email' => $agen->email, 'password' => 'pendek', 'password_confirmation' => 'lain',
        ])->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_super_can_update_reset_delete_and_restore_admin(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($this->super)->patch(route('sup.admin.update', $admin), ['name' => 'Nama Baru', 'email' => 'baru@example.com'])
            ->assertSessionHasNoErrors();
        $this->assertSame('baru@example.com', $admin->fresh()->email);

        $this->actingAs($this->super)->patch(route('sup.admin.password', $admin), [
            'password' => 'passwordbaru1', 'password_confirmation' => 'passwordbaru1',
        ])->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check('passwordbaru1', $admin->fresh()->password));

        $this->actingAs($this->super)->delete(route('sup.admin.delete', $admin))->assertRedirect(route('sup.admin'));
        $this->assertSoftDeleted($admin);
        $this->actingAs($this->super)->get(route('sup.admin', ['tab' => 'terhapus']))->assertSee('baru@example.com');

        $this->actingAs($this->super)->patch(route('sup.admin.restore', $admin))->assertSessionHasNoErrors();
        $this->assertNotSoftDeleted($admin);
    }

    public function test_super_cannot_manage_non_admin_accounts_or_delete_self(): void
    {
        $agen = Agent::factory()->create()->hasUser;
        $superLain = User::factory()->super()->create();

        $this->actingAs($this->super)->delete(route('sup.admin.delete', $agen))->assertNotFound();
        $this->actingAs($this->super)->delete(route('sup.admin.delete', $superLain))->assertNotFound();
        $this->actingAs($this->super)->delete(route('sup.admin.delete', $this->super))->assertNotFound();
        $this->actingAs($this->super)->patch(route('sup.admin.password', $agen), [
            'password' => 'passwordbaru1', 'password_confirmation' => 'passwordbaru1',
        ])->assertNotFound();

        $this->assertNotSoftDeleted($agen);
        $this->assertNotSoftDeleted($this->super);
    }

    public function test_admin_cannot_manage_admins(): void
    {
        $admin = User::factory()->admin()->create();
        $adminLain = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('sup.admin'))->assertForbidden();
        $this->actingAs($admin)->delete(route('sup.admin.delete', $adminLain))->assertForbidden();
        $this->assertNotSoftDeleted($adminLain);
    }

    public function test_admin_and_super_can_change_own_password(): void
    {
        foreach ([User::factory()->admin()->create(), $this->super] as $user) {
            $this->actingAs($user)->get(route('adm.password'))->assertOk()->assertSee('Ubah Password');

            $this->actingAs($user)->from(route('adm.password'))->put(route('password.update'), [
                'current_password' => 'password',
                'password' => 'passwordku-baru',
                'password_confirmation' => 'passwordku-baru',
            ])->assertRedirect(route('adm.password'))->assertSessionHasNoErrors();

            $this->assertTrue(Hash::check('passwordku-baru', $user->fresh()->password));
        }
    }

    public function test_topbar_shows_logged_in_user_instead_of_template_sample(): void
    {
        $admin = User::factory()->admin()->create(['name' => 'Rudi Admin']);

        $this->actingAs($admin)->get(route('adm.dashboard'))
            ->assertSee('Rudi Admin')
            ->assertSee('Administrator')
            ->assertDontSee('Anna Adame');
    }
}
