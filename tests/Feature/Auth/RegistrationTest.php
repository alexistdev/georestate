<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register_as_user(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'user',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('front.home'));

        $user = User::where('email', 'test@example.com')->first();
        $this->assertTrue($user->hasRole('user'));
        $this->assertNull($user->hasAgent);
    }

    public function test_new_users_can_register_as_agen(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Agen',
            'email' => 'agen@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'agen',
            'phone' => '081234567890',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('agn.dashboard'));

        $user = User::where('email', 'agen@example.com')->first();
        $this->assertTrue($user->hasRole('agen'));
        $this->assertSame('081234567890', $user->hasAgent->phone);
    }

    public function test_agen_registration_requires_phone(): void
    {
        $this->post('/register', [
            'name' => 'Test Agen',
            'email' => 'agen@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'agen',
        ])->assertSessionHasErrors('phone');

        $this->assertGuest();
    }

    public function test_users_can_not_register_as_admin(): void
    {
        $this->post('/register', [
            'name' => 'Penyusup',
            'email' => 'evil@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'admin',
        ])->assertSessionHasErrors('role');

        $this->assertGuest();
    }
}
