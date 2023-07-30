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
            array('code' => '11','name' => 'aceh','created_at' => $date,'updated_at' => $date),
            array('code' => '12','name' => 'sumatera utara','created_at' => $date,'updated_at' => $date),
            array('code' => '13','name' => 'sumatera barat','created_at' => $date,'updated_at' => $date),
            array('code' => '14','name' => 'riau','created_at' => $date,'updated_at' => $date),
            array('code' => '15','name' => 'jambi','created_at' => $date,'updated_at' => $date),
            array('code' => '16','name' => 'sumatera selatan','created_at' => $date,'updated_at' => $date),
            array('code' => '17','name' => 'bengkulu','created_at' => $date,'updated_at' => $date),
            array('code' => '18','name' => 'lampung','created_at' => $date,'updated_at' => $date),
            array('code' => '19','name' => 'kepulauan bangka belitung','created_at' => $date,'updated_at' => $date),
            array('code' => '21','name' => 'kepulauan riau','created_at' => $date,'updated_at' => $date),
            array('code' => '31','name' => 'dki jakarta','created_at' => $date,'updated_at' => $date),
            array('code' => '32','name' => 'jawa barat','created_at' => $date,'updated_at' => $date),
            array('code' => '33','name' => 'jawa tengah','created_at' => $date,'updated_at' => $date),
            array('code' => '34','name' => 'di yogyakarta','created_at' => $date,'updated_at' => $date),
            array('code' => '35','name' => 'jawa timur','created_at' => $date,'updated_at' => $date),
            array('code' => '36','name' => 'banten','created_at' => $date,'updated_at' => $date),
            array('code' => '51','name' => 'bali','created_at' => $date,'updated_at' => $date),
            array('code' => '52','name' => 'nusa tenggara barat','created_at' => $date,'updated_at' => $date),
            array('code' => '53','name' => 'nusa tenggara timur','created_at' => $date,'updated_at' => $date),
            array('code' => '61','name' => 'kalimantan barat','created_at' => $date,'updated_at' => $date),
            array('code' => '62','name' => 'kalimantan tengah','created_at' => $date,'updated_at' => $date),
            array('code' => '63','name' => 'kalimantan selatan','created_at' => $date,'updated_at' => $date),
            array('code' => '64','name' => 'kalimantan timur','created_at' => $date,'updated_at' => $date),
            array('code' => '65','name' => 'kalimantan utara','created_at' => $date,'updated_at' => $date),
            array('code' => '71','name' => 'sulawesi utara','created_at' => $date,'updated_at' => $date),
            array('code' => '72','name' => 'sulawesi tengah','created_at' => $date,'updated_at' => $date),
            array('code' => '73','name' => 'sulawesi selatan','created_at' => $date,'updated_at' => $date),
            array('code' => '74','name' => 'sulawesi tenggara','created_at' => $date,'updated_at' => $date),
            array('code' => '75','name' => 'gorontalo','created_at' => $date,'updated_at' => $date),
            array('code' => '76','name' => 'sulawesi barat','created_at' => $date,'updated_at' => $date),
            array('code' => '81','name' => 'maluku','created_at' => $date,'updated_at' => $date),
            array('code' => '82','name' => 'maluku utara','created_at' => $date,'updated_at' => $date),
            array('code' => '91','name' => 'papua barat','created_at' => $date,'updated_at' => $date),
            array('code' => '94','name' => 'papua','created_at' => $date,'updated_at' => $date),
        ];
        Provinsi::insert($provinsi);
    }
}
