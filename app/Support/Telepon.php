<?php

namespace App\Support;

/**
 * Format nomor telepon Indonesia untuk tautan telepon & WhatsApp.
 */
class Telepon
{
    /**
     * Nomor format internasional tanpa "+", mis. 0812-3456 → 628123456. Null jika kosong.
     */
    public static function internasional(?string $nomor): ?string
    {
        $angka = preg_replace('/\D/', '', (string) $nomor);
        if ($angka === '') {
            return null;
        }
        if (str_starts_with($angka, '0')) {
            return '62'.substr($angka, 1);
        }
        if (str_starts_with($angka, '8')) {
            return '62'.$angka;
        }
        return $angka;
    }

    public static function whatsappUrl(?string $nomor, ?string $pesan = null): ?string
    {
        $angka = self::internasional($nomor);
        if ($angka === null) {
            return null;
        }
        return 'https://wa.me/'.$angka.($pesan ? '?text='.rawurlencode($pesan) : '');
    }

    public static function teleponUrl(?string $nomor): ?string
    {
        $angka = self::internasional($nomor);

        return $angka ? 'tel:+'.$angka : null;
    }
}
