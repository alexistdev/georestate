<?php

namespace Tests\Feature\Admin;

use App\Enums\PropertyStatus;
use App\Models\Agent;
use App\Models\ContactMessage;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModerasiTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_pending_queue_shows_oldest_first_and_counts_per_status(): void
    {
        Property::factory()->create(['name' => 'Pending Baru', 'updated_at' => now()]);
        Property::factory()->create(['name' => 'Pending Lama', 'updated_at' => now()->subDays(3)]);
        Property::factory()->approved()->create(['name' => 'Sudah Tayang']);

        $this->actingAs($this->admin)->get(route('adm.listing'))
            ->assertOk()
            ->assertSeeInOrder(['Pending Lama', 'Pending Baru'])
            ->assertDontSee('Sudah Tayang');

        $this->actingAs($this->admin)->get(route('adm.listing', ['status' => 'approved']))
            ->assertSee('Sudah Tayang')
            ->assertDontSee('Pending Lama');
    }

    public function test_admin_can_review_and_approve_listing(): void
    {
        $property = Property::factory()->create(['name' => 'Kos Menunggu']);

        $this->actingAs($this->admin)->get(route('adm.listing.show', $property))
            ->assertOk()
            ->assertSee('Kos Menunggu')
            ->assertSee('Setujui');

        $this->actingAs($this->admin)->patch(route('adm.listing.approve', $property))
            ->assertRedirect(route('adm.listing', ['status' => 'pending']))
            ->assertSessionHas('success');

        $property->refresh();
        $this->assertSame(PropertyStatus::Approved, $property->status);
        $this->assertNotNull($property->approved_at);
        $this->get(route('front.properties.detail', $property->slug))->assertOk();
    }

    public function test_reject_requires_reason(): void
    {
        $property = Property::factory()->create();

        $this->actingAs($this->admin)
            ->patch(route('adm.listing.reject', $property), ['alasan_penolakan' => ''])
            ->assertSessionHasErrors('alasan_penolakan');

        $this->assertSame(PropertyStatus::Pending, $property->fresh()->status);
    }

    public function test_admin_can_reject_or_take_down_listing(): void
    {
        $property = Property::factory()->approved()->create();

        $this->actingAs($this->admin)
            ->patch(route('adm.listing.reject', $property), ['alasan_penolakan' => 'Harga tidak wajar'])
            ->assertSessionHasNoErrors();

        $property->refresh();
        $this->assertSame(PropertyStatus::Rejected, $property->status);
        $this->assertSame('Harga tidak wajar', $property->alasan_penolakan);
        $this->assertNull($property->approved_at);
        $this->get(route('front.properties.detail', $property->slug))->assertNotFound();
    }

    public function test_super_admin_can_moderate_but_agen_cannot(): void
    {
        $property = Property::factory()->create();

        $this->actingAs(User::factory()->super()->create())
            ->get(route('adm.listing'))->assertOk();

        $agen = Agent::factory()->create()->hasUser;
        $this->actingAs($agen)->get(route('adm.listing'))->assertForbidden();
        $this->actingAs($agen)->patch(route('adm.listing.approve', $property))->assertForbidden();
        $this->assertSame(PropertyStatus::Pending, $property->fresh()->status);
    }

    public function test_dashboard_shows_counts_and_queue(): void
    {
        Property::factory()->count(2)->create();
        Property::factory()->approved()->create();
        Property::factory()->create(['name' => 'Antrean Pertama', 'updated_at' => now()->subWeek()]);
        ContactMessage::create(['name' => 'Rina', 'email' => 'rina@example.com', 'message' => 'Halo']);

        $this->actingAs($this->admin)->get(route('adm.dashboard'))
            ->assertOk()
            ->assertSee('Antrean Pertama')
            ->assertSee('Rina')
            ->assertSeeInOrder(['Menunggu Persetujuan', '3'])
            // CSS kartu statistik dari komponen harus masuk ke <head> layout.
            ->assertSeeInOrder(['.stat-card--warning', '</head>', 'stat-card stat-card--warning'], false);
    }

    public function test_contact_messages_can_be_read_and_deleted(): void
    {
        $pesan = ContactMessage::create(['name' => 'Budi', 'email' => 'budi@example.com', 'subject' => 'Tanya', 'message' => 'Apakah masih ada?']);

        $this->actingAs($this->admin)->get(route('adm.pesan', ['filter' => 'baru']))
            ->assertOk()->assertSee('Budi');

        $this->actingAs($this->admin)->get(route('adm.pesan.show', $pesan))
            ->assertOk()->assertSee('Apakah masih ada?');
        $this->assertNotNull($pesan->fresh()->read_at);

        $this->actingAs($this->admin)->get(route('adm.pesan', ['filter' => 'baru']))
            ->assertDontSee('budi@example.com');

        $this->actingAs($this->admin)->delete(route('adm.pesan.delete', $pesan))
            ->assertRedirect(route('adm.pesan'));
        $this->assertDatabaseMissing('contact_messages', ['id' => $pesan->id]);
    }
}
