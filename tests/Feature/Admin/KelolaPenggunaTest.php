<?php

namespace Tests\Feature\Admin;

use App\Models\Agent;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KelolaPenggunaTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_agent_list_tabs_search_and_detail(): void
    {
        $aktif = Agent::factory()->create();
        $aktif->hasUser->update(['name' => 'Budi Aktif']);
        $suspend = Agent::factory()->create(['isSuspend' => true, 'alasan_suspend' => 'Listing palsu']);
        $suspend->hasUser->update(['name' => 'Sinta Suspend']);
        Property::factory()->for($aktif)->approved()->create(['name' => 'Kos Milik Budi']);

        $this->actingAs($this->admin)->get(route('adm.agent'))
            ->assertOk()->assertSee('Budi Aktif')->assertDontSee('Sinta Suspend')
            ->assertDontSee('Premium');

        $this->actingAs($this->admin)->get(route('adm.agent', ['tab' => 'suspend']))
            ->assertSee('Sinta Suspend')->assertSee('Listing palsu')->assertDontSee('Budi Aktif');

        $this->actingAs($this->admin)->get(route('adm.agent', ['q' => 'budi']))
            ->assertSee('Budi Aktif');

        $this->actingAs($this->admin)->get(route('adm.agent.show', $aktif))
            ->assertOk()->assertSee('Kos Milik Budi')->assertSee('Suspend Agen');
    }

    public function test_suspend_requires_reason_hides_listings_and_blocks_login(): void
    {
        $agent = Agent::factory()->create();
        $listing = Property::factory()->for($agent)->approved()->create();

        $this->actingAs($this->admin)->patch(route('adm.agent.suspend', $agent), ['alasan_suspend' => ''])
            ->assertSessionHasErrors('alasan_suspend');
        $this->assertFalse($agent->fresh()->isSuspend);

        $this->actingAs($this->admin)->patch(route('adm.agent.suspend', $agent), ['alasan_suspend' => 'Banyak laporan penipuan'])
            ->assertRedirect(route('adm.agent.show', $agent));

        $agent->refresh();
        $this->assertTrue($agent->isSuspend);
        $this->assertNotNull($agent->suspended_at);
        $this->get(route('front.properties.detail', $listing->slug))->assertNotFound();

        $this->post('/logout');
        $this->post('/login', ['email' => $agent->hasUser->email, 'password' => 'password'])
            ->assertSessionHasErrors(['email' => 'Akun agen Anda disuspend: Banyak laporan penipuan. Silakan hubungi administrator.']);
        $this->assertGuest();
    }

    public function test_logged_in_agent_is_logged_out_when_suspended(): void
    {
        $agent = Agent::factory()->create();
        $this->actingAs($agent->hasUser)->get(route('agn.dashboard'))->assertOk();

        $agent->forceFill(['isSuspend' => true, 'alasan_suspend' => 'Pelanggaran aturan'])->save();

        $this->get(route('agn.dashboard'))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_activate_restores_listings_and_login(): void
    {
        $agent = Agent::factory()->create(['isSuspend' => true, 'alasan_suspend' => 'Tes', 'suspended_at' => now()]);
        $listing = Property::factory()->for($agent)->approved()->create();

        $this->actingAs($this->admin)->patch(route('adm.agent.aktifkan', $agent))->assertSessionHasNoErrors();

        $agent->refresh();
        $this->assertFalse($agent->isSuspend);
        $this->assertNull($agent->alasan_suspend);
        $this->get(route('front.properties.detail', $listing->slug))->assertOk();
    }

    public function test_delete_and_restore_agent(): void
    {
        $agent = Agent::factory()->create();
        $email = $agent->hasUser->email;
        $listing = Property::factory()->for($agent)->approved()->create();

        $this->actingAs($this->admin)->delete(route('adm.agent.delete', $agent))
            ->assertRedirect(route('adm.agent', ['tab' => 'terhapus']));

        $this->assertSoftDeleted($agent);
        $this->assertSoftDeleted($agent->hasUser()->withTrashed()->first());
        $this->get(route('front.properties.detail', $listing->slug))->assertNotFound();

        $this->actingAs($this->admin)->get(route('adm.agent', ['tab' => 'terhapus']))->assertSee($email);
        $this->actingAs($this->admin)->get(route('adm.agent.show', $agent))->assertOk()->assertSee('Pulihkan Agen');

        $this->post('/logout');
        $this->post('/login', ['email' => $email, 'password' => 'password']);
        $this->assertGuest();

        $this->actingAs($this->admin)->patch(route('adm.agent.restore', $agent))
            ->assertRedirect(route('adm.agent.show', $agent));
        $this->assertNotSoftDeleted($agent);
        $this->assertNotSoftDeleted($agent->hasUser);
        $this->get(route('front.properties.detail', $listing->slug))->assertOk();
    }

    public function test_user_list_delete_and_restore(): void
    {
        $user = User::factory()->create(['name' => 'Pencari Satu']);
        $agen = Agent::factory()->create()->hasUser;

        $this->actingAs($this->admin)->get(route('adm.user'))
            ->assertOk()->assertSee('Pencari Satu')->assertDontSee($agen->email);

        $this->actingAs($this->admin)->delete(route('adm.user.delete', $user))->assertRedirect(route('adm.user'));
        $this->assertSoftDeleted($user);

        $this->actingAs($this->admin)->get(route('adm.user', ['tab' => 'terhapus']))->assertSee('Pencari Satu');

        $this->actingAs($this->admin)->patch(route('adm.user.restore', $user))->assertSessionHasNoErrors();
        $this->assertNotSoftDeleted($user);
    }

    public function test_user_page_cannot_delete_admin_or_agent_accounts(): void
    {
        $agen = Agent::factory()->create()->hasUser;

        $this->actingAs($this->admin)->delete(route('adm.user.delete', $agen))->assertNotFound();
        $this->actingAs($this->admin)->delete(route('adm.user.delete', $this->admin))->assertNotFound();
        $this->assertNotSoftDeleted($agen);
    }

    public function test_agent_cannot_manage_users(): void
    {
        $agen = Agent::factory()->create()->hasUser;
        $user = User::factory()->create();

        $this->actingAs($agen)->get(route('adm.agent'))->assertForbidden();
        $this->actingAs($agen)->delete(route('adm.user.delete', $user))->assertForbidden();
    }
}
