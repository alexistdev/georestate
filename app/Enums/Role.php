<?php

namespace App\Enums;

/**
 * Nama role sesuai kolom `roles.name`.
 * Jangan bergantung pada ID numerik role karena urutan seeder bisa berubah.
 */
enum Role: string
{
    case Super = 'super';
    case Admin = 'admin';
    case Agen = 'agen';
    case User = 'user';

    public function label(): string
    {
        return match ($this) {
            self::Super => 'Super Admin',
            self::Admin => 'Administrator',
            self::Agen => 'Agen',
            self::User => 'Pencari Properti',
        };
    }

    /**
     * Halaman tujuan setelah login untuk tiap role.
     */
    public function homeRoute(): string
    {
        return match ($this) {
            self::Super => 'sup.dashboard',
            self::Admin => 'adm.dashboard',
            self::Agen => 'agn.dashboard',
            self::User => 'front.home',
        };
    }

    /**
     * Role yang boleh dipilih saat registrasi mandiri.
     */
    public static function registrable(): array
    {
        return [self::Agen->value, self::User->value];
    }
}
