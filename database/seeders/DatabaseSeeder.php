<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            KategoriSeeder::class,
            FasilitasSeeder::class,
            UserSeeder::class,
            ProvinsiSeeder::class,
            KabupatenSeeder::class,
            KecamatanSeeder::class,
            AgentSeeder::class,
        ]);

        // Data contoh (agen, listing disetujui, foto) hanya untuk pengembangan.
        if (app()->environment('local')) {
            $this->call(DemoListingSeeder::class);
        }
    }
}
