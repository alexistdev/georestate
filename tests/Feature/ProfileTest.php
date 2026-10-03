<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_redirects_by_role(): void
    {
        // Halaman profil Breeze tidak dipakai; /profile diarahkan ke halaman profil/akun sesuai peran.
        $this->actingAs(User::factory()->create())->get('/profile')->assertRedirect(route('usr.password'));
        $this->actingAs(User::factory()->admin()->create())->get('/profile')->assertRedirect(route('adm.password'));
        $this->actingAs(User::factory()->super()->create())->get('/profile')->assertRedirect(route('adm.password'));
        $this->actingAs(\App\Models\Agent::factory()->create()->hasUser)->get('/profile')->assertRedirect(route('agn.profil'));
    }
}
