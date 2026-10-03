<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now()->format('Y-m-d H:i:s');
        $kategori = [
            array('name'=>'Apartemen','created_at' => $date,'updated_at' => $date),
            array('name'=>'Rumah','created_at' => $date,'updated_at' => $date),
            array('name'=>'Ruko','created_at' => $date,'updated_at' => $date),
        ];
        Kategori::insert($kategori);
    }
}
