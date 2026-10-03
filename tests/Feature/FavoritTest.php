<?php

namespace Tests\Feature;

use App\Models\Agent;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoritTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_and_remove_favorite(): void
    {
        $user = User::factory()->create();
        $property = Property::factory()->approved()->create(['name' => 'Kos Favorit']);

        $this->actingAs($user)->from(route('front.properties'))
            ->post(route('front.favorit.toggle', $property->slug))
            ->assertRedirect(route('front.properties'))
            ->assertSessionHas('favorit_success');
        $this->assertTrue($user->favorit()->whereKey($property->id)->exists());

        $this->actingAs($user)->get(route('usr.favorit'))->assertOk()->assertSee('Kos Favorit');
        $this->actingAs($user)->get(route('front.properties.detail', $property->slug))->assertSee('Tersimpan di Favorit');

        $this->actingAs($user)->post(route('front.favorit.toggle', $property->slug));
        $this->assertFalse($user->favorit()->whereKey($property->id)->exists());
    }

    public function test_guest_is_sent_to_login_and_returns_to_property(): void
    {
        $property = Property::factory()->approved()->create();
        $user = User::factory()->create();

        $this->get(route('front.properties.detail', $property->slug))
            ->assertSee(route('front.favorit.masuk', $property->slug), false);

        $this->get(route('front.favorit.masuk', $property->slug))
            ->assertRedirect(route('login'))
            ->assertSessionHas('status');

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route('front.properties.detail', $property->slug));

        $this->post(route('front.favorit.toggle', $property->slug));
        $this->assertDatabaseHas('favorites', ['user_id' => $user->id, 'property_id' => $property->id]);
    }

    public function test_guest_cannot_post_favorite(): void
    {
        $property = Property::factory()->approved()->create();

        $this->post(route('front.favorit.toggle', $property->slug))->assertRedirect(route('login'));
        $this->assertDatabaseCount('favorites', 0);
    }

    public function test_favorites_hide_listings_that_are_no_longer_public(): void
    {
        $user = User::factory()->create();
        $tayang = Property::factory()->approved()->create(['name' => 'Masih Tayang']);
        $diturunkan = Property::factory()->approved()->create(['name' => 'Sudah Diturunkan']);
        $user->favorit()->attach([$tayang->id, $diturunkan->id]);

        $diturunkan->forceFill(['status' => 'rejected'])->save();

        $this->actingAs($user)->get(route('usr.favorit'))
            ->assertSee('Masih Tayang')->assertDontSee('Sudah Diturunkan');
    }

    public function test_agents_do_not_get_favorites_or_user_area(): void
    {
        $agen = Agent::factory()->create()->hasUser;
        $property = Property::factory()->approved()->create();

        $this->actingAs($agen)->get(route('front.properties.detail', $property->slug))
            ->assertDontSee('Simpan Favorit');
        $this->actingAs($agen)->post(route('front.favorit.toggle', $property->slug))->assertForbidden();
        $this->actingAs($agen)->get(route('usr.favorit'))->assertForbidden();
    }

    public function test_user_area_pages_and_header_link(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('front.home'))->assertSee('AKUN SAYA');
        $this->actingAs($user)->get(route('usr.favorit'))->assertOk()->assertSee('Belum ada properti favorit');
        $this->actingAs($user)->get(route('usr.pertanyaan'))->assertOk()->assertSee('Belum ada pertanyaan');
        $this->actingAs($user)->get(route('usr.password'))->assertOk()->assertSee('Password Saat Ini');
    }
}
