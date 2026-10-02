<?php

namespace Tests\Feature\Front;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_message_is_saved(): void
    {
        $this->post(route('front.contact.store'), [
            'name' => 'Rina',
            'email' => 'rina@example.com',
            'phone' => '08123',
            'subject' => 'Tanya listing',
            'message' => 'Apakah masih tersedia?',
        ])
            ->assertRedirect(route('front.contact'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'rina@example.com',
            'message' => 'Apakah masih tersedia?',
            'read_at' => null,
        ]);
    }

    public function test_contact_message_requires_name_email_and_message(): void
    {
        $this->post(route('front.contact.store'), [])
            ->assertSessionHasErrors(['name', 'email', 'message']);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_honeypot_blocks_bots(): void
    {
        $this->post(route('front.contact.store'), [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'message' => 'spam',
            'website' => 'http://spam.example',
        ])->assertSessionHasErrors('website');

        $this->assertDatabaseCount('contact_messages', 0);
    }
}
