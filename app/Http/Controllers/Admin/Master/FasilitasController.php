<?php

namespace App\Http\Controllers\Admin\Master;

use App\Models\Fasilitas;

class FasilitasController extends MasterNamaController
{
    protected function model(): string
    {
        return Fasilitas::class;
    }

    protected function info(): array
    {
        return [
            'judul' => 'Fasilitas',
            'route' => 'adm.fasilitas',
            'label' => 'Fasilitas',
            'contoh' => 'Contoh: Kolam Renang, Balkon, Akses 24 Jam',
            'menuKedua' => 'fasilitas',
        ];
    }
}
