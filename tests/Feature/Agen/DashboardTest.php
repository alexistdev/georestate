<?php

namespace Tests\Feature\Agen;

use App\Models\Agent;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_agent_dashboard_shows_moderation_notifications(): void
    {
        $agent = Agent::factory()->create();
        Property::factory()->for($agent)->rejected('Foto buram sekali')->create(['name' => 'Kos Ditolak']);
        Property::factory()->for($agent)->approved()->create(['name' => 'Kos Disetujui']);
        Property::factory()->for($agent)->approved()->create(['name' => 'Disetujui Lama', 'approved_at' => now()->subMonth()]);
        Property::factory()->for($agent)->create();
        Property::factory()->rejected()->create(['name' => 'Milik Agen Lain']);

        $this->actingAs($agent->hasUser)->get(route('agn.dashboard'))
            ->assertOk()
            ->assertSee('Kos Ditolak')
            ->assertSee('Foto buram sekali')
            ->assertSee('Kos Disetujui')
            ->assertDontSee('Disetujui Lama')
            ->assertDontSee('Milik Agen Lain')
            ->assertSeeInOrder(['Tayang di Website', '2', 'Menunggu Persetujuan', '1', 'Ditolak', '1']);
    }
}
