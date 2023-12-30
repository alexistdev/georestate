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
            array('name'=>'apartement','created_at' => $date,'updated_at' => $date),
            array('name'=>'rumah','created_at' => $date,'updated_at' => $date),
            array('name'=>'ruko','created_at' => $date,'updated_at' => $date),
        ];
        Kategori::insert($kategori);
    }
}
