# Analisis & Roadmap — GeoRestate

_Terakhir diperbarui: 3 Oktober 2026 (Fase 0–5 dan 6A selesai)._

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
| Area super | ✅ Semua hak admin + dashboard (kartu jumlah admin) + kelola akun Admin |
| Ubah password admin/super di panel admin | ✅ `/staff/password` |
| Admin: master wilayah (provinsi/kabupaten/kecamatan) | ✅ CRUD + validasi |
| Admin: dashboard statistik, moderasi listing (setujui / tolak / turunkan + alasan), pesan Kontak | ✅ Fase 3A |
| Admin: kelola agen (suspend/aktifkan, hapus/pulihkan) & pencari properti (hapus/pulihkan) | ✅ Fase 3B |
| Admin: master kategori & fasilitas (tambah, ubah, hapus, pulihkan) | ✅ Fase 3C |
| Agen: CRUD listing (milik sendiri), harga per periode, fasilitas, foto, status | ✅ |
| Agen: dashboard (jumlah per status + notifikasi disetujui/ditolak) | ✅ |
| Agen: Profil Saya (data diri, wilayah, foto, email, password) + pengingat profil belum lengkap | ✅ Fase 5 |
| Tanya agen (inquiry), kotak masuk agen, favorit, area Akun Saya pencari properti | ✅ Fase 4 |
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
- Validasi `exists` (listing agen) dan `EncodedIdExists` (form wilayah base64). *(6B: base64 diganti ID asli + `Rule::exists()->withoutTrashed()`, `EncodedIdExists` dihapus.)*
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
**3C ✅ SELESAI** (keputusan: kategori terhapus wajib diganti saat listing diedit; fasilitas terhapus terlepas saat listing disimpan ulang; nama unik tanpa beda huruf besar/kecil; nama kategori tampil sesuai input)
- `/staff/kategori` & `/staff/fasilitas` (menu Master Data): tab Aktif/Terhapus, cari, jumlah listing pemakai, tambah, ubah (modal), hapus (soft delete), pulihkan (ditolak jika nama sudah dipakai data aktif). Satu controller dasar `Admin\Master\MasterNamaController` + view `admin/master-nama.blade.php`.
- Rule `App\Rules\NamaUnik` (unik di antara data aktif, case-insensitive); spasi berlebih dirapikan.
- Relasi `Property::kategori()` & `fasilitas()` memakai `withTrashed()` sehingga listing lama tetap menampilkan data yang sudah dihapus; form agen & filter publik hanya menampilkan data aktif; form edit memberi petunjuk jika kategori lama sudah dihapus.
- Huruf besar paksa (accessor) pada `Kategori` dihapus; migrasi `normalize_kategori_names` merapikan data lama (Title Case, "apartement" → "Apartemen"); seeder disesuaikan.
- Test: `tests/Feature/Admin/MasterKategoriFasilitasTest.php`.
**3D ✅ SELESAI** (keputusan: dashboard super = dashboard admin + jumlah admin; super hanya membuat akun Admin; password awal ditentukan super; hapus admin = soft delete)
- Dashboard super `/super/dashboard` memakai data dashboard admin + kartu "Akun Admin"; menu Dashboard mengarah sesuai peran; menu "Kelola Admin" hanya untuk super.
- Kelola admin `/super/admin`: tab Aktif/Terhapus, cari, tambah (nama, email, password awal), ubah nama/email, reset password (modal), hapus (soft delete) & pulihkan. Hanya akun ber-role Admin; super tidak bisa mengelola akun super/agen/pencari atau menghapus dirinya; admin biasa 403.
- Ubah password `/staff/password` untuk admin & super (form Bootstrap, simpan via route bawaan `password.update`).
- Topbar admin: nama, peran (`Role::label()`), email, Ubah Password, Logout (data contoh template dihapus).
- `public/css/georestate-admin.css`: warna teks tombol `btn-soft-*` Velzon digelapkan (kontras 1.9–3:1 → ≥5:1), dimuat di layout admin & agen.
- Perbaikan: `User::hasRole()` menerima enum dengan benar; role dicari dengan `firstOrCreate` saat membuat akun.
- Test: `tests/Feature/Super/KelolaAdminTest.php`.

### Fase 4 — User & inquiry ✅ SELESAI
Keputusan: tanya agen boleh tanpa login; favorit wajib login; status Baru / Sudah Dihubungi / Selesai; email notifikasi ditunda; admin hanya melihat & menghapus spam.
- Tabel `inquiries` (property_id, agent_id, user_id nullable, nama, email, telepon, pesan, status, read_at) & `favorites` (user_id, property_id). Enum `InquiryStatus`.
- Detail properti: form "Tanya Agen" (`POST /properties/{slug}/tanya`, throttle 5/menit + honeypot; data terisi otomatis jika login) dan tombol ❤ (juga di kartu listing). Tamu → `/properties/{slug}/favorit/masuk` → login → kembali ke properti.
- Agen: menu Pertanyaan (badge baru) `/agent/pertanyaan`, tab per status, detail (otomatis dibaca), balas via WhatsApp/email (pesan terisi), ubah status; notifikasi di dashboard. Sidebar agen dirapikan (bagian "Promosi" berisi link mati dihapus).
- Pencari properti: Akun Saya `/akun/favorit`, `/akun/pertanyaan` (status terlihat), `/akun/password`; header menampilkan "AKUN SAYA". Favorit hanya menampilkan listing yang masih tayang.
- Admin: `/staff/pertanyaan` lihat semua, cari, hapus.
- `App\Support\Telepon` untuk format nomor/WhatsApp (dipakai Agent & Inquiry). DemoListingSeeder menambah 2 pertanyaan & 2 favorit contoh.
- Test: `tests/Feature/InquiryTest.php`, `tests/Feature/FavoritTest.php`.

### Fase 5 — Profil agen ✅ SELESAI
Keputusan: foto dipotong otomatis di tengah; ganti email wajib password saat ini; telepon tetap wajib; pengingat profil tidak memblokir; `/profile` Breeze dialihkan sesuai peran. (Premium tetap ditunda.)
- Profil Saya `/agent/profil` (menu sidebar & topbar): nama, telepon/WhatsApp (wajib, format divalidasi), alamat, wilayah berantai (memakai endpoint `front.wilayah.*`), Tentang Saya, foto profil (JPG/PNG/WebP ≤ 2 MB, disimpan di `storage/app/public/agents/{id}`; foto lama dihapus saat diganti). Service `Agen\ProfilService`.
- Ganti email (`PATCH /agent/profil/email`, wajib password saat ini) & ubah password (route bawaan `password.update`) di halaman yang sama.
- Dashboard agen: pengingat jika foto, kecamatan, atau Tentang Saya masih kosong.
- Topbar agen: foto, nama, peran, Profil Saya, Ubah Password, Logout (data contoh template dihapus).
- Foto agen di website ditampilkan bulat & terpotong rapi (`object-fit: cover`).
- `GET /profile` (Breeze) dialihkan: agen → Profil Saya, admin/super → Ubah Password, pencari → Akun Saya. Route `PATCH/DELETE /profile` bawaan Breeze dihapus di 6B.
- Test: `tests/Feature/Agen/ProfilTest.php`.

### Fase 6 — Polish & deploy
Keputusan: logo sementara wordmark teks; peta Leaflet + OpenStreetMap; "Lupa password" disembunyikan sampai email disiapkan (admin mereset dari panel); timezone Asia/Jakarta; hapus hanya aset template yang terbukti tidak dipakai. Target server (shared hosting/VPS) ditanyakan di 6D.

**6A ✅ SELESAI — Tampilan & branding**
- Logo wordmark SVG `public/images/logo/` (logo-dark, logo-light, logo-icon) + favicon (`favicon.svg`, `favicon.ico`, PNG 32 & apple-touch 180) lewat partial `partials/favicon`; dipasang di website, panel admin/agen, login/daftar, halaman error. Ganti file di folder itu untuk memakai logo resmi.
- Topbar admin & agen ditulis ulang tanpa contoh template (pencarian, menu aplikasi, notifikasi palsu, keranjang); tersisa logo, menu, layar penuh, mode gelap, menu user.
- Halaman login: carousel testimoni template diganti keunggulan GeoRestate, teks berbahasa Indonesia.
- Halaman lupa password, reset password, verifikasi email, konfirmasi password memakai komponen Bootstrap `<x-auth-card>` (tanpa `npm run build`). "Lupa password?" hanya tampil jika `App\Support\Fitur::emailAktif()` (mailer bukan log/array); permintaan reset ditolak jika email belum aktif.
- Admin mereset password agen (`PATCH /staff/agent/{agent}/password`) & pencari properti (`PATCH /staff/user/{user}/password`).
- Halaman error bertema 403/404/419/429/500/503 + halaman lisensi memakai `errors/layout.blade.php` (berdiri sendiri, tanpa DB/sesi).
- SEO: meta description, canonical, Open Graph & Twitter card di layout publik; detail properti & profil agen mengisi deskripsi + gambar pratinjau; `/sitemap.xml` (halaman publik, listing tayang, agen aktif) & `/robots.txt` dinamis (blokir /staff, /super, /agent, /akun, /login, /register; file statis `public/robots.txt` dihapus).
- Test: `tests/Feature/TampilanTest.php`, `PasswordResetTest` disesuaikan.

**6B ✅ SELESAI — Bersih-bersih teknis**
- `DisctricController`/`DisctrictServiceImpl` → `DistrictController`/`DistrictServiceImpl`; nama route `adm.disctrict*` → `adm.wilayah*` (URL tetap `/staff/wilayah`).
- Form wilayah admin & form listing agen memakai ID asli (bukan base64); validasi `Rule::exists(...)->withoutTrashed()`. `App\Rules\EncodedIdExists` dan `App\Casts\Base64` dihapus.
- Tabel provinsi/kabupaten/kecamatan memakai DataTables **server-side** (paging, cari, urut di server; ±7.200 kecamatan tidak lagi dimuat sekaligus). Label tabel berbahasa Indonesia.
- Dropdown wilayah form listing agen memakai endpoint publik `front.wilayah.*` (sama dengan filter pencarian & profil agen); route `agn.lists.kabupaten/kecamatan` dihapus.
- Dihapus: view Breeze/Tailwind (`layouts/*`, `dashboard`, `welcome`, `auth/login`, `auth/register`, `profile/*`, komponen Tailwind), `AppLayout`/`GuestLayout`, `ProfileController` + route `PATCH/DELETE /profile`, middleware `isFree`, `XssClean`, `PreventBackHistory`, `Authenticate`, `RedirectIfAuthenticated`, `TrustHosts`, `app/Exceptions/Handler.php`, serta tooling Vite/Tailwind (`package.json`, `vite.config.js`, `tailwind.config.js`, `postcss.config.js`, `resources/css`, `resources/js`). Aplikasi tidak butuh Node/npm.
- Kolom `properties.isStatus` dihapus (migration `2026_10_08_000001`); `kelurahan_id` dibuang dari `Agent::$fillable`.
- Accessor nama wilayah: disimpan huruf kecil (sesuai seeder), tampil huruf kapital; sekarang aman multibyte + `trim`.
- Timezone `Asia/Jakarta` (bisa diubah lewat `APP_TIMEZONE`).
- Test: `tests/Feature/Admin/DistrictTest.php` (ID asli, server-side, halaman wilayah).

**6C–6D (belum):**
1. Aktifkan peta lokasi Leaflet + OSM (lihat kerangka di Fase 2) — 6C.
2. CI (`pint --test` + `php artisan test`), checklist `.env` produksi, cron, email/SMTP, panduan deploy — 6D.
3. Bersihkan aset `public/template` (±242 MB) yang terbukti tidak dipakai — 6D.

## 5. Utang teknis yang diketahui

- Data `created_at` lama yang dibuat sebelum 6B tersimpan dalam UTC; setelah timezone diganti ke WIB, waktunya tampil 7 jam lebih awal. Tidak masalah untuk data dev (`migrate:fresh --seed`).
- Halaman login & daftar masih memakai foto latar stok dari template Velzon (`auth-one-bg`); ganti jika ingin foto sendiri.
- Gambar demo template Porto (`template/frontend/img/demos/real-estate/**`: slider, background, listing, generic) ternyata PNG kosong/transparan, jadi tidak dipakai lagi di halaman publik.
