<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

/**
 * Validasi ID yang dikirim dalam bentuk base64 (dipakai form wilayah admin):
 * harus bisa di-decode menjadi angka dan ada di tabel (belum di-soft delete).
 */
class EncodedIdExists implements ValidationRule
{
    public function __construct(private string $table)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $id = base64_decode((string) $value, true);

        $exists = $id !== false && ctype_digit($id) && DB::table($this->table)
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->exists();

        if (!$exists) {
            $fail('Data tidak ditemukan, silahkan refresh halaman!');
        }
    }
}
