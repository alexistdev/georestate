<?php

namespace Database\Seeders;

use App\Models\Provinsi;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now()->format('Y-m-d H:i:s');
        $provinsi = [
            array('name' => 'aceh','created_at' => $date,'updated_at' => $date),
            array('name' => 'sumatera utara','created_at' => $date,'updated_at' => $date),
            array('name' => 'sumatera barat','created_at' => $date,'updated_at' => $date),
            array('name' => 'riau','created_at' => $date,'updated_at' => $date),
            array('name' => 'jambi','created_at' => $date,'updated_at' => $date),
            array('name' => 'sumatera selatan','created_at' => $date,'updated_at' => $date),
            array('name' => 'bengkulu','created_at' => $date,'updated_at' => $date),
            array('name' => 'lampung','created_at' => $date,'updated_at' => $date),
            array('name' => 'kepulauan bangka belitung','created_at' => $date,'updated_at' => $date),
            array('name' => 'kepulauan riau','created_at' => $date,'updated_at' => $date),
            array('name' => 'dki jakarta','created_at' => $date,'updated_at' => $date),
            array('name' => 'jawa barat','created_at' => $date,'updated_at' => $date),
            array('name' => 'jawa tengah','created_at' => $date,'updated_at' => $date),
            array('name' => 'di yogyakarta','created_at' => $date,'updated_at' => $date),
            array('name' => 'jawa timur','created_at' => $date,'updated_at' => $date),
            array('name' => 'banten','created_at' => $date,'updated_at' => $date),
            array('name' => 'bali','created_at' => $date,'updated_at' => $date),
            array('name' => 'nusa tenggara barat','created_at' => $date,'updated_at' => $date),
            array('name' => 'nusa tenggara timur','created_at' => $date,'updated_at' => $date),
            array('name' => 'kalimantan barat','created_at' => $date,'updated_at' => $date),
            array('name' => 'kalimantan tengah','created_at' => $date,'updated_at' => $date),
            array('name' => 'kalimantan selatan','created_at' => $date,'updated_at' => $date),
            array('name' => 'kalimantan timur','created_at' => $date,'updated_at' => $date),
            array('name' => 'kalimantan utara','created_at' => $date,'updated_at' => $date),
            array('name' => 'sulawesi utara','created_at' => $date,'updated_at' => $date),
            array('name' => 'sulawesi tengah','created_at' => $date,'updated_at' => $date),
            array('name' => 'sulawesi selatan','created_at' => $date,'updated_at' => $date),
            array('name' => 'sulawesi tenggara','created_at' => $date,'updated_at' => $date),
            array('name' => 'gorontalo','created_at' => $date,'updated_at' => $date),
            array('name' => 'sulawesi barat','created_at' => $date,'updated_at' => $date),
            array('name' => 'maluku','created_at' => $date,'updated_at' => $date),
            array('name' => 'maluku utara','created_at' => $date,'updated_at' => $date),
            array('name' => 'papua barat','created_at' => $date,'updated_at' => $date),
            array('name' => 'papua','created_at' => $date,'updated_at' => $date),
        ];
        Provinsi::insert($provinsi);
    }
}
