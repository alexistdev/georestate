# Analisis & Roadmap — GeoRestate

_Terakhir diperbarui: 3 Oktober 2026 (Fase 0, 1, 2, 3A, dan 3B selesai)._

## 1. Ringkasan

GeoRestate adalah aplikasi manajemen real estate (kos, kamar sewa, apartemen, rumah, ruko) berbasis **Laravel 12 + MySQL**, dengan template Bootstrap (admin: Velzon, frontend: Porto) dan DataTables (yajra).

Role: `super`, `admin`, `agen`, `user` (lihat `App\Enums\Role`).

## 2. Keputusan produk (dari pemilik project)

1. Role **super** punya area sendiri (`/super/...`).
2. **Agen bisa mendaftar sendiri** di `/register` (pilih jenis akun agen/user).
3. **Listing wajib disetujui admin** sebelum tampil di frontend.
4. Transaksi **hanya contact ke agen** (inquiry), tanpa booking/pembayaran.
5. Harga sewa **harian, bulanan, dan tahunan**.
6. Fitur properti dari **master fasilitas** (checkbox), bukan teks bebas.
7. **Premium: ditunda**, belum diputuskan. Jangan diimplementasi dulu.

## 3. Status modul

| Modul | Status |
|---|---|
| Login + redirect per role, `/dashboard` → dashboard sesuai role | ✅ |
| Registrasi user / agen | ✅ (agen melengkapi wilayah nanti di profil) |
| Area super | ⚠️ Punya semua hak admin (akses `/staff/*`); dashboard & kelola akun admin di Fase 3D |
| Admin: master wilayah (provinsi/kabupaten/kecamatan) | ✅ CRUD + validasi |
| Admin: dashboard statistik, moderasi listing (setujui / tolak / turunkan + alasan), pesan Kontak | ✅ Fase 3A |
| Admin: kelola agen (suspend/aktifkan, hapus/pulihkan) & pencari properti (hapus/pulihkan) | ✅ Fase 3B |
| Admin: kategori & fasilitas (3C) | ❌ |
| Agen: CRUD listing (milik sendiri), harga per periode, fasilitas, foto, status | ✅ |
| Agen: dashboard (jumlah per status + notifikasi disetujui/ditolak) | ✅ |
| Agen: profil | ❌ |
| User: favorit, kirim pesan ke agen | ❌ (sementara pengunjung menghubungi agen via WhatsApp/telepon) |
| Frontend publik (home, cari & filter properti, detail, agen, tentang, kontak) | ✅ Hanya listing `approved` dari agen yang tidak disuspend |
| Peta lokasi | ⚠️ Kerangka saja (kolom koordinat + placeholder), dikerjakan di akhir project |
| Pesan form Kontak | ✅ Tersimpan di `contact_messages`; dibaca admin di `/staff/pesan` |
| Test | ✅ Fondasi siap (SQLite in-memory, factory, test role & wilayah) |

## 4. Roadmap

### Fase 0 — Fondasi & keamanan ✅ SELESAI
- `phpunit.xml` memakai SQLite in-memory (dulu test mengosongkan DB MySQL dev).
- Enum `Role`, redirect login per role, area super, `/dashboard` redirect per role.
- Registrasi user/agen (`register2.blade.php`, Bootstrap).
- Halaman publik tanpa middleware `guest`.
- Escape HTML di DataTables (XSS), error tidak lagi di-`echo`.
- Validasi `exists` (listing agen) dan `EncodedIdExists` (form wilayah base64).
- `Property` memakai `HasUuids` (dulu `id` tertimpa auto-increment setelah `save()`).
- Factory: User (state `super/admin/agen`), Provinsi, Kabupaten, Kecamatan, Kategori, Agent, Property.
- Fix form tambah listing (old value kamar mandi, URL ajax, isi ulang dropdown wilayah).
- Login: link daftar & lupa password, remember me. README disamakan dengan seeder.

### Fase 1 — Listing properti agen (inti bisnis) ✅ SELESAI
1. Migrasi: `properties.agent_id` (FK uuid ke `agents`), `slug`, `status` (`pending`/`approved`/`rejected`), `alasan_penolakan`, `approved_at`.
2. Harga: `harga_harian`, `harga_bulanan`, `harga_tahunan` (nullable, minimal satu wajib diisi) menggantikan `price`. Hapus accessor `price` yang mengembalikan string.
3. Master fasilitas: tabel `fasilitas` + pivot `fasilitas_property`, menggantikan `features` / `feature1..4`.
4. `PropertyPolicy`: agen hanya kelola miliknya.
5. CRUD lengkap agen: index (milik sendiri), create, edit/update (kembali ke `pending`), show, delete (soft delete).
6. Upload multi-gambar ke `storage/app/public/properties`, gambar default, hapus gambar.
7. Feature test (`tests/Feature/Agen/ListingTest.php`).

Catatan implementasi: kolom `price` dan tabel `features` dihapus; foto di disk `public` (`storage/app/public/properties/{id}`, butuh `php artisan storage:link`); edit listing selalu mengembalikan status ke `pending`; maksimal 10 foto @ 2 MB (JPG/PNG/WebP); daftar fasilitas awal di `FasilitasSeeder`.

### Fase 2 — Frontend publik dinamis ✅ SELESAI
1. Home: form pencarian cepat, listing terbaru, kategori + jumlah listing, carousel agen.
2. `/properties`: filter kata kunci, kategori, provinsi/kabupaten/kecamatan (AJAX `front.wilayah.*`), periode, rentang harga, kamar; urut terbaru/termurah/termahal; paginate. Harga di kartu mengikuti periode yang difilter.
3. `/properties/{slug}`: galeri, harga per periode, fasilitas, kerangka peta, kartu agen (telepon + WhatsApp `wa.me/62…` dengan pesan otomatis), properti serupa.
4. `/agents`, `/agents/{uuid}` (profil + listing agen).
5. Kontak: form tersimpan ke `contact_messages` (throttle 5/menit + honeypot `website`). Tentang: teks umum (sesuaikan).
6. Info situs (nama, alamat, telepon, email) di `config/georestate.php` / `.env` (`GEORESTATE_*`).
7. `DemoListingSeeder`: 3 agen tambahan (`agen2..4@gmail.com`, password `1234`) + 12 listing disetujui + 1 pending + 1 ditolak, foto dibuat dengan GD. Hanya jalan di `APP_ENV=local`.
8. Test: `tests/Feature/Front/*`, `tests/Unit/AgentPhoneTest.php`.

Kerangka peta (dikerjakan setelah project selesai): kolom `properties.latitude/longitude` (nullable) + partial `front/partials/peta-lokasi.blade.php` berisi TODO. Langkah lanjut: input titik di form agen, muat Leaflet/OSM, render marker.

### Lisensi GeoLicense ✅ TERPASANG
Plugin dari `geolicense/CLIENT/LARAVEL` (server: https://geolicense.my.id). File: `config/geolicense.php`, `app/Services/GeoLicense/*`, `app/Http/Middleware/LicenseValidationMiddleware.php` (global), `app/Providers/GeoLicenseServiceProvider.php`, command `geolicense:verify` (dijadwalkan per jam di `routes/console.php`), halaman `resources/views/errors/license.blade.php`.

Penyesuaian terhadap plugin asli:
1. Kirim `productSku` (`GEOLICENSE_PRODUCT_SKU`) di activate & verify. Server sekarang mewajibkannya, sedangkan plugin Laravel asli belum (plugin Spring Boot sudah).
2. Lisensi wajib di semua environment (termasuk development); tidak ada saklar untuk mematikannya. Khusus test otomatis, `tests/TestCase.php` menandai lisensi valid dan memblokir request HTTP keluar.
3. Aktivasi gagal saat boot tidak lagi melempar exception (yang membuat seluruh app & artisan error 500). Kegagalan dicatat di log dan dicoba lagi setelah `GEOLICENSE_ACTIVATION_RETRY_MINS` (default 5 menit) supaya server yang down tidak memperlambat setiap request.
4. Halaman HTML 503 untuk browser; JSON tetap untuk request API.
5. `SETUP.md` asli memakai `->everyHour()` (tidak ada di Laravel) → diganti `->hourly()`.

Saran: terapkan poin 1–5 juga ke plugin di `geolicense/CLIENT/LARAVEL` agar project lain ikut mendapat perbaikan.

### Fase 3 — Admin & Super
Keputusan: Super = semua hak Admin + kelola akun Admin; tolak listing wajib alasan; notifikasi moderasi cukup di dashboard agen (belum email); kategori/fasilitas boleh dihapus (soft delete, listing lama tetap menampilkan); hapus agen = soft delete.

**3A ✅ SELESAI**
- Moderasi listing `/staff/listing`: tab Menunggu/Disetujui/Ditolak + jumlah, cari nama, antrean pending terlama di atas. Halaman tinjau: foto, harga, fasilitas, agen; Setujui & Tayangkan, Tolak (alasan wajib), Turunkan listing yang sudah tayang. Service `Admin\ModerasiService`.
- Dashboard admin: jumlah listing per status, agen aktif/suspend, pencari properti, pesan belum dibaca; antrean moderasi & pesan terbaru.
- Pesan Kontak `/staff/pesan`: filter belum dibaca, baca (otomatis ditandai dibaca), balas via email (mailto), hapus.
- Menu admin: Dashboard, Moderasi Listing (badge pending), Pesan Kontak (badge belum dibaca). Judul halaman admin tidak lagi "Velzon".
- Route admin terbuka untuk role `super`.
- Dashboard agen: jumlah per status, notifikasi listing ditolak (+alasan, tombol Perbaiki) dan disetujui 7 hari terakhir.
- Test: `tests/Feature/Admin/ModerasiTest.php`, `tests/Feature/Agen/DashboardTest.php`.

**3B ✅ SELESAI** (keputusan: alasan suspend wajib & tampil ke agen saat login; kolom Premium/Free disembunyikan; pencari properti cukup hapus/pulihkan; admin tidak membuat akun agen)
- Kelola agen `/staff/agent`: tab Aktif/Disuspend/Terhapus + jumlah, cari nama/email/telepon, jumlah listing per status. DataTables lama diganti tabel server-side.
- Detail agen: profil, kontak, wilayah, daftar listing (link ke moderasi).
- Suspend (alasan wajib; kolom `agents.alasan_suspend`, `suspended_at`) / Aktifkan. Agen disuspend tidak bisa login (pesan berisi alasan) dan langsung dikeluarkan dari sesi aktif (`CekRole`); listing-nya hilang dari website.
- Hapus agen = soft delete agen + akun user-nya (tidak bisa login, listing hilang), bisa dipulihkan dari tab Terhapus.
- Kelola pencari properti `/staff/user`: tab Aktif/Terhapus, cari, hapus & pulihkan (hanya akun role user).
- Menu admin: Pengguna → Agen, Pencari Properti. Service `Admin\AgentService` berisi suspend/aktifkan/hapus/pulihkan.
- Test: `tests/Feature/Admin/KelolaPenggunaTest.php`.
**3C** Master kategori & fasilitas.
**3D** Area super: dashboard & navbar sendiri, kelola akun admin.

### Fase 4 — User & inquiry
1. Tabel `inquiries` (property_id, user_id/nama/email/telepon tamu, pesan, status).
2. Form contact di detail properti + notifikasi email ke agen.
3. Agen: kotak masuk inquiry.
4. User: favorit, riwayat inquiry.

### Fase 5 — Profil agen
Foto, telepon, alamat, wilayah (kecamatan), about. Ganti halaman profil Breeze/Tailwind. (Premium ditunda.)

### Fase 6 — Polish & deploy
1. Ganti sisa halaman Breeze/Tailwind (lupa password, reset, verifikasi email, profil) ke Bootstrap; setelah itu `npm run build` tidak wajib lagi.
2. Rename `Disctric*` → `District*`.
3. DataTables server-side (sekarang `->get()` memuat ~7.000 kecamatan per request).
4. Ganti ID base64 di form wilayah dengan ID asli + otorisasi.
5. Halaman 404/403/500 bertema, SEO dasar, CI (`pint --test` + `php artisan test`).
6. Bersihkan aset `public/template` (±242 MB) yang tidak dipakai.
7. Ganti logo Porto (`template/frontend/img/demos/real-estate/logo.png`) dan favicon dengan logo GeoRestate.
8. Aktifkan peta lokasi (lihat kerangka di Fase 2).

## 5. Utang teknis yang diketahui

- Halaman Breeze (lupa password, reset, verifikasi email, profil) memakai `@vite` → **error 500 jika belum `npm run build`**.
- `XssClean` men-`strip_tags` semua input → akan merusak deskripsi rich text; nanti escape saat output saja.
- Accessor `name` wilayah/kategori: `strtoupper` saat baca, `strtolower` saat simpan, sedangkan seeder menyimpan UPPERCASE.
- `Agent::$fillable` menyebut `kelurahan_id` yang tidak ada di tabel.
- Middleware `isFree`, `PreventBackHistory`, dan `app/Exceptions/Handler.php` tidak dipakai.
- `config/app.php` timezone masih `UTC`, sehingga waktu tampil 7 jam lebih awal dari WIB. Pertimbangkan `Asia/Jakarta`.
- Kolom `properties.isStatus` tidak jelas fungsinya dan tidak dipakai (digantikan `status`).
- Gambar demo template Porto (`template/frontend/img/demos/real-estate/**`: slider, background, listing, generic) ternyata PNG kosong/transparan, jadi tidak dipakai lagi di halaman publik.
