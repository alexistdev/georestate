{{--
    Layout halaman error (berdiri sendiri: tanpa database, sesi, atau aset template,
    supaya tetap tampil saat aplikasi sedang bermasalah).
    Variabel: $kode, $judul, $pesan, $tombolBeranda (default true)
--}}
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    @include('partials.favicon')
    <title>{{ $judul }} | {{ config('georestate.nama', 'GeoRestate') }}</title>
    <style>
        :root { --biru: #1c5fa8; --teks: #1f2a37; --redup: #5b6576; }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center;
               font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; background: #f3f6fa; color: var(--teks); }
        .kotak { width: 100%; max-width: 480px; margin: 16px; padding: 40px 32px; background: #fff; border-radius: 16px;
                 box-shadow: 0 1px 2px rgba(16, 24, 40, .04), 0 8px 28px rgba(16, 24, 40, .08); text-align: center; }
        .logo { height: 34px; margin-bottom: 28px; }
        .kode { font-size: 56px; font-weight: 800; line-height: 1; color: var(--biru); letter-spacing: -1px; margin: 0 0 8px; }
        h1 { font-size: 20px; margin: 0 0 12px; }
        p { margin: 0 0 24px; line-height: 1.6; color: var(--redup); }
        .tombol { display: inline-block; padding: 10px 22px; border-radius: 8px; background: var(--biru); color: #fff;
                  text-decoration: none; font-weight: 600; font-size: 14px; }
        .tombol:hover { background: #164d89; }
        .tombol-kedua { background: transparent; color: var(--biru); border: 1px solid #c9d6e8; margin-left: 6px; }
        .tombol-kedua:hover { background: #eef3fa; }
    </style>
</head>
<body>
<main class="kotak">
    <img src="{{ asset('images/logo/logo-dark.svg') }}" alt="{{ config('georestate.nama', 'GeoRestate') }}" class="logo">
    @isset($kode)<p class="kode">{{ $kode }}</p>@endisset
    <h1>{{ $judul }}</h1>
    <p>{{ $pesan }}</p>
    @if($tombolBeranda ?? true)
        <a href="{{ url('/') }}" class="tombol">Ke Beranda</a>
        <a href="javascript:history.back()" class="tombol tombol-kedua">Kembali</a>
    @endif
</main>
</body>
</html>
