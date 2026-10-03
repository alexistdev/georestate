<?php

namespace App\Enums;

/**
 * Status pertanyaan calon penyewa, diubah oleh agen dan terlihat oleh penanya.
 */
enum InquiryStatus: string
{
    case Baru = 'baru';
    case Dihubungi = 'dihubungi';
    case Selesai = 'selesai';

    public function label(): string
    {
        return match ($this) {
            self::Baru => 'Baru',
            self::Dihubungi => 'Sudah Dihubungi',
            self::Selesai => 'Selesai',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::Baru => 'danger',
            self::Dihubungi => 'warning',
            self::Selesai => 'success',
        };
    }
}
