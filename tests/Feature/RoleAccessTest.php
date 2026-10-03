<?php

namespace Tests\Feature;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_each_role_can_open_its_own_dashboard(): void
    {
        $this->actingAs(User::factory()->super()->create())
            ->get(route('sup.dashboard'))->assertOk();

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('adm.dashboard'))->assertOk();

        $this->actingAs(Agent::factory()->create()->hasUser)
            ->get(route('agn.dashboard'))->assertOk();
    }

    public function test_roles_can_not_open_other_role_areas(): void
    {
        $agen = User::factory()->agen()->create();
        $this->actingAs($agen)->get(route('adm.dashboard'))->assertForbidden();
        $this->actingAs($agen)->get(route('sup.dashboard'))->assertForbidden();

        $user = User::factory()->create();
        $this->actingAs($user)->get(route('agn.dashboard'))->assertForbidden();
    }

    public function test_dashboard_route_redirects_by_role(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get('/dashboard')->assertRedirect(route('adm.dashboard'));
    }

    public function test_public_pages_are_accessible_when_logged_in(): void
    {
        $this->actingAs(User::factory()->agen()->create())
            ->get(route('front.home'))->assertOk();
    }
}
