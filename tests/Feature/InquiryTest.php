<?php

namespace Tests\Feature;

use App\Enums\InquiryStatus;
use App\Models\Agent;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InquiryTest extends TestCase
{
    use RefreshDatabase;

    private function kirim(Property $property, array $data = [])
    {
        return $this->post(route('front.inquiry.store', $property->slug), array_merge([
            'name' => 'Rina',
            'email' => 'rina@example.com',
            'phone' => '0812-1111-2222',
            'message' => 'Apakah masih tersedia?',
        ], $data));
    }

    private function buatPertanyaan(Property $property, array $data = []): Inquiry
    {
        return Inquiry::create(array_merge([
            'property_id' => $property->id,
            'agent_id' => $property->agent_id,
            'name' => 'Penanya',
            'email' => 'penanya@example.com',
            'phone' => '081234567890',
            'message' => 'Masih ada?',
        ], $data));
    }

    public function test_guest_can_send_inquiry_to_agent(): void
    {
        $property = Property::factory()->approved()->create();

        $this->kirim($property)
            ->assertRedirect(route('front.properties.detail', $property->slug).'#tanya-agen')
            ->assertSessionHas('inquiry_success');

        $this->assertDatabaseHas('inquiries', [
            'property_id' => $property->id,
            'agent_id' => $property->agent_id,
            'user_id' => null,
            'email' => 'rina@example.com',
            'status' => 'baru',
        ]);
    }

    public function test_logged_in_user_inquiry_is_prefilled_and_saved_to_history(): void
    {
        $user = User::factory()->create(['name' => 'Budi Pencari', 'email' => 'budi@example.com']);
        $property = Property::factory()->approved()->create(['name' => 'Kos Anggrek']);

        $this->actingAs($user)->get(route('front.properties.detail', $property->slug))
            ->assertSee('value="Budi Pencari"', false)
            ->assertSee('value="budi@example.com"', false);

        $this->actingAs($user)->kirim($property, ['name' => 'Budi Pencari', 'email' => 'budi@example.com']);

        $inquiry = Inquiry::firstOrFail();
        $this->assertSame($user->id, $inquiry->user_id);

        $this->actingAs($user)->get(route('usr.pertanyaan'))
            ->assertOk()->assertSee('Kos Anggrek')->assertSee('Baru');
    }

    public function test_inquiry_validation_spam_and_unpublished_listing(): void
    {
        $property = Property::factory()->approved()->create();

        $this->kirim($property, ['name' => '', 'message' => ''])->assertSessionHasErrors(['name', 'message']);
        $this->kirim($property, ['website' => 'http://spam.example'])->assertSessionHasErrors('website');

        $pending = Property::factory()->create();
        $this->kirim($pending)->assertNotFound();

        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_agent_inbox_shows_only_own_inquiries_and_marks_read(): void
    {
        $agent = Agent::factory()->create();
        $milik = $this->buatPertanyaan(Property::factory()->approved()->for($agent)->create(), ['name' => 'Penanya Saya']);
        $this->buatPertanyaan(Property::factory()->approved()->create(), ['name' => 'Penanya Agen Lain']);

        $this->actingAs($agent->hasUser)->get(route('agn.dashboard'))->assertSee('1 pertanyaan baru');

        $this->actingAs($agent->hasUser)->get(route('agn.pertanyaan'))
            ->assertOk()->assertSee('Penanya Saya')->assertDontSee('Penanya Agen Lain');

        $this->actingAs($agent->hasUser)->get(route('agn.pertanyaan.show', $milik))
            ->assertOk()
            ->assertSee('Masih ada?')
            ->assertSee('https://wa.me/6281234567890', false);
        $this->assertNotNull($milik->fresh()->read_at);
    }

    public function test_agent_can_update_status_and_user_sees_it(): void
    {
        $user = User::factory()->create();
        $agent = Agent::factory()->create();
        $inquiry = $this->buatPertanyaan(Property::factory()->approved()->for($agent)->create(), ['user_id' => $user->id]);

        $this->actingAs($agent->hasUser)->patch(route('agn.pertanyaan.status', $inquiry), ['status' => 'dihubungi'])
            ->assertSessionHasNoErrors();
        $this->assertSame(InquiryStatus::Dihubungi, $inquiry->fresh()->status);

        $this->actingAs($agent->hasUser)->patch(route('agn.pertanyaan.status', $inquiry), ['status' => 'ngawur'])
            ->assertSessionHasErrors('status');

        $this->actingAs($user)->get(route('usr.pertanyaan'))->assertSee('Sudah Dihubungi');
    }

    public function test_agent_cannot_access_other_agents_inquiry(): void
    {
        $agent = Agent::factory()->create();
        $lain = $this->buatPertanyaan(Property::factory()->approved()->create());

        $this->actingAs($agent->hasUser)->get(route('agn.pertanyaan.show', $lain))->assertForbidden();
        $this->actingAs($agent->hasUser)->patch(route('agn.pertanyaan.status', $lain), ['status' => 'selesai'])->assertForbidden();
        $this->assertSame(InquiryStatus::Baru, $lain->fresh()->status);
    }

    public function test_admin_can_view_and_delete_inquiries(): void
    {
        $admin = User::factory()->admin()->create();
        $inquiry = $this->buatPertanyaan(Property::factory()->approved()->create(), ['message' => 'Promo obat kuat murah']);

        $this->actingAs($admin)->get(route('adm.pertanyaan', ['q' => 'promo']))
            ->assertOk()->assertSee('Promo obat kuat murah');

        $this->actingAs($admin)->delete(route('adm.pertanyaan.delete', $inquiry))->assertRedirect(route('adm.pertanyaan'));
        $this->assertDatabaseCount('inquiries', 0);

        $agen = Agent::factory()->create()->hasUser;
        $this->actingAs($agen)->get(route('adm.pertanyaan'))->assertForbidden();
    }
}
