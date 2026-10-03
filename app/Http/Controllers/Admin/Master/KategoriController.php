<?php

namespace App\Http\Controllers\Admin\Master;

use App\Models\Kategori;

class KategoriController extends MasterNamaController
{
    protected function model(): string
    {
        return Kategori::class;
    }

    protected function info(): array
    {
        return [
            'judul' => 'Kategori Properti',
            'route' => 'adm.kategori',
            'label' => 'Kategori',
            'contoh' => 'Contoh: Kos, Villa, Gudang',
            'menuKedua' => 'kategori',
        ];
    }
}
