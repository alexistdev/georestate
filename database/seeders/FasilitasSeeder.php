<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $date = Carbon::now()->format('Y-m-d H:i:s');
        $fasilitas = [
            'AC', 'WiFi', 'Parkir Mobil', 'Parkir Motor', 'Kamar Mandi Dalam', 'Dapur',
            'Kasur', 'Lemari', 'Water Heater', 'Laundry', 'CCTV', 'Keamanan 24 Jam',
        ];

        Fasilitas::insert(array_map(fn ($name) => [
            'name' => $name,
            'created_at' => $date,
            'updated_at' => $date,
        ], $fasilitas));
    }
}
