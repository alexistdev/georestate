<?php

namespace Database\Seeders;

use App\Enums\PropertyStatus;
use App\Enums\Role as RoleEnum;
use App\Models\Agent;
use App\Models\Fasilitas;
use App\Models\Gambar;
use App\Models\Kategori;
use App\Models\Kecamatan;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Data contoh untuk pengembangan: beberapa agen dan listing yang sudah disetujui, lengkap dengan foto.
 * Hanya dijalankan di environment local (lihat DatabaseSeeder).
 */
class DemoListingSeeder extends Seeder
{
    private const WARNA = [
        [47, 111, 159], [122, 79, 160], [46, 139, 87], [196, 98, 45], [70, 90, 120], [160, 60, 80],
    ];

    public function run(): void
    {
        $faker = fake('id_ID');
        $kecamatan = Kecamatan::whereHas('kabupaten', fn ($q) => $q->where('name', 'like', 'kota %'))
            ->inRandomOrder()->limit(30)->pluck('id');
        $kategori = Kategori::pluck('id', 'name');
        $fasilitas = Fasilitas::pluck('id');

        // Agen contoh tambahan (password: 1234), plus agen dari AgentSeeder.
        $agents = collect([Agent::whereHas('hasUser', fn ($q) => $q->where('email', 'agen@gmail.com'))->first()])
            ->filter()
            ->concat(collect(['Budi Santoso', 'Siti Rahmawati', 'Andi Pratama'])->map(function ($nama, $i) use ($faker, $kecamatan) {
                $user = User::factory()->agen()->create([
                    'name' => $nama,
                    'email' => 'agen'.($i + 2).'@gmail.com',
                    'password' => '1234',
                ]);

                return Agent::create([
                    'user_id' => $user->id,
                    'member_identifier' => (string) Str::ulid(),
                    'phone' => '08'.$faker->numerify('##########'),
                    'alamat' => $faker->streetAddress(),
                    'about' => 'Agen properti berpengalaman yang siap membantu Anda menemukan hunian sewa yang nyaman.',
                    'kecamatan_id' => $kecamatan->random(),
                ]);
            }));

        $contoh = [
            ['Kos Putri Nyaman Dekat Kampus', 'rumah', ['harga_bulanan' => 850000], 1, 1],
            ['Kos Putra Eksklusif AC + WiFi', 'rumah', ['harga_harian' => 90000, 'harga_bulanan' => 1200000], 1, 1],
            ['Rumah Minimalis 2 Lantai Siap Huni', 'rumah', ['harga_bulanan' => 3500000, 'harga_tahunan' => 38000000], 3, 2],
            ['Rumah Keluarga Dekat Sekolah', 'rumah', ['harga_tahunan' => 25000000], 3, 1],
            ['Apartemen Studio Pusat Kota', 'apartement', ['harga_harian' => 350000, 'harga_bulanan' => 4500000], 1, 1],
            ['Apartemen 2 Kamar View Kota', 'apartement', ['harga_bulanan' => 7000000, 'harga_tahunan' => 78000000], 2, 1],
            ['Apartemen Furnished Dekat Mall', 'apartement', ['harga_harian' => 450000], 1, 1],
            ['Ruko 3 Lantai Pinggir Jalan Utama', 'ruko', ['harga_tahunan' => 90000000], 0, 2],
            ['Ruko Strategis Dekat Pasar', 'ruko', ['harga_bulanan' => 6500000, 'harga_tahunan' => 70000000], 0, 1],
            ['Kamar Kos Harian Murah', 'rumah', ['harga_harian' => 75000, 'harga_bulanan' => 900000], 1, 1],
            ['Rumah Asri dengan Taman', 'rumah', ['harga_bulanan' => 2800000], 2, 1],
            ['Apartemen Mewah Penthouse', 'apartement', ['harga_bulanan' => 15000000, 'harga_tahunan' => 165000000], 3, 3],
        ];

        foreach ($contoh as $i => [$nama, $namaKategori, $harga, $beds, $baths]) {
            $property = Property::create(array_merge([
                'agent_id' => $agents[$i % $agents->count()]->id,
                'name' => $nama,
                'kategori_id' => $kategori[$namaKategori] ?? $kategori->first(),
                'kecamatan_id' => $kecamatan->random(),
                'address' => $faker->streetAddress(),
                'description' => $nama.". Lokasi strategis, lingkungan aman dan nyaman.\nAkses mudah ke fasilitas umum seperti minimarket, rumah makan, dan transportasi.",
                'beds' => $beds,
                'baths' => $baths,
                'lt' => $faker->numberBetween(3, 20) * 10,
                'lb' => $faker->numberBetween(3, 15) * 10,
            ], $harga));

            $property->forceFill([
                'status' => PropertyStatus::Approved,
                'approved_at' => now()->subDays(count($contoh) - $i),
            ])->save();

            $property->fasilitas()->sync($fasilitas->random(min(5, $fasilitas->count()))->all());

            foreach (range(1, 3) as $urutan) {
                $property->gambars()->create([
                    'name' => $this->buatFoto($property, $urutan, ($i + $urutan) % count(self::WARNA)),
                    'isDefault' => $urutan === 1,
                ]);
            }
        }

        // Contoh status lain untuk akun agen@gmail.com.
        if ($agentUtama = $agents->first()) {
            $this->listingStatus($agentUtama, 'Kos Baru Menunggu Persetujuan', PropertyStatus::Pending, $kecamatan->random(), $kategori->first());
            $this->listingStatus($agentUtama, 'Listing Ditolak Contoh', PropertyStatus::Rejected, $kecamatan->random(), $kategori->first());
        }
    }

    private function listingStatus(Agent $agent, string $nama, PropertyStatus $status, int $kecamatanId, int $kategoriId): void
    {
        $property = Property::create([
            'agent_id' => $agent->id,
            'name' => $nama,
            'kategori_id' => $kategoriId,
            'kecamatan_id' => $kecamatanId,
            'lt' => 40,
            'lb' => 30,
            'harga_bulanan' => 1000000,
        ]);
        $property->forceFill([
            'status' => $status,
            'alasan_penolakan' => $status === PropertyStatus::Rejected ? 'Foto kurang jelas, mohon unggah foto yang lebih terang.' : null,
        ])->save();
        $property->gambars()->create(['name' => $this->buatFoto($property, 1, 4), 'isDefault' => true]);
    }

    /**
     * Buat foto placeholder (ilustrasi rumah sederhana) dan simpan di disk public.
     */
    private function buatFoto(Property $property, int $urutan, int $indexWarna): string
    {
        [$r, $g, $b] = self::WARNA[$indexWarna];
        $img = imagecreatetruecolor(900, 600);
        imagefill($img, 0, 0, imagecolorallocate($img, $r, $g, $b));

        $terang = imagecolorallocate($img, min($r + 70, 255), min($g + 70, 255), min($b + 70, 255));
        $putih = imagecolorallocate($img, 255, 255, 255);
        imagefilledrectangle($img, 0, 470, 900, 600, imagecolorallocate($img, max($r - 25, 0), max($g - 25, 0), max($b - 25, 0)));
        imagefilledpolygon($img, [270, 250, 450, 110, 630, 250], $terang);
        imagefilledrectangle($img, 300, 250, 600, 470, $terang);
        imagefilledrectangle($img, 420, 360, 480, 470, imagecolorallocate($img, $r, $g, $b));
        imagefilledrectangle($img, 330, 290, 390, 340, $putih);
        imagefilledrectangle($img, 510, 290, 570, 340, $putih);
        imagestring($img, 5, 30, 540, Str::limit($property->name, 60).' - Foto '.$urutan, $putih);

        ob_start();
        imagejpeg($img, null, 85);
        $isi = ob_get_clean();
        imagedestroy($img);

        $path = 'properties/'.$property->id.'/demo-'.$urutan.'.jpg';
        Storage::disk(Gambar::DISK)->put($path, $isi);

        return $path;
    }
}
