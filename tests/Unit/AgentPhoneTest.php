<?php

namespace Tests\Unit;

use App\Models\Agent;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AgentPhoneTest extends TestCase
{
    public static function nomorProvider(): array
    {
        return [
            'awalan 0' => ['081234567890', '6281234567890'],
            'dengan spasi & strip' => ['0812-3456 7890', '6281234567890'],
            'awalan +62' => ['+62 812 3456 7890', '6281234567890'],
            'awalan 62' => ['6281234567890', '6281234567890'],
            'awalan 8' => ['81234567890', '6281234567890'],
            'kosong' => ['', null],
            'null' => [null, null],
        ];
    }

    #[DataProvider('nomorProvider')]
    public function test_nomor_internasional(?string $phone, ?string $harapan): void
    {
        $agent = new Agent(['phone' => $phone]);

        $this->assertSame($harapan, $agent->nomorInternasional());
    }

    public function test_whatsapp_url_with_message(): void
    {
        $agent = new Agent(['phone' => '081234567890']);

        $this->assertSame('https://wa.me/6281234567890?text=Halo%20kak', $agent->whatsappUrl('Halo kak'));
        $this->assertSame('tel:+6281234567890', $agent->teleponUrl());
        $this->assertNull((new Agent())->whatsappUrl());
    }
}
