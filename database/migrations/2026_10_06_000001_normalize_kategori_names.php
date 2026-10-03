<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Nama kategori dulu disimpan huruf kecil dan ditampilkan HURUF BESAR oleh accessor model.
     * Sekarang nama ditampilkan apa adanya, jadi data lama dirapikan (Title Case) dan
     * salah ketik "apartement" diperbaiki menjadi "Apartemen".
     */
    public function up(): void
    {
        DB::table('kategoris')->orderBy('id')->each(function ($kategori) {
            $nama = strtolower(trim($kategori->name)) === 'apartement'
                ? 'Apartemen'
                : ucwords(strtolower(trim($kategori->name)));

            DB::table('kategoris')->where('id', $kategori->id)->update(['name' => $nama]);
        });
    }

    public function down(): void
    {
        DB::table('kategoris')->orderBy('id')->each(function ($kategori) {
            $nama = $kategori->name === 'Apartemen' ? 'apartement' : strtolower($kategori->name);

            DB::table('kategoris')->where('id', $kategori->id)->update(['name' => $nama]);
        });
    }
};
