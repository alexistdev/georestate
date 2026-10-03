{{--
    Kerangka halaman autentikasi (lupa/reset password, verifikasi email, konfirmasi password)
    dengan tampilan yang sama seperti halaman login; tidak butuh `npm run build`.
--}}
@props(['judul', 'subjudul' => null])
<!doctype html>
<html lang="id" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>{{ $judul }} | {{ config('georestate.nama') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    @include('partials.favicon')
    <script src="{{ asset('template/admin/assets/js/layout.js') }}"></script>
    <link href="{{ asset('template/admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/admin/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/georestate-admin.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
    <div class="bg-overlay"></div>
    <div class="auth-page-content overflow-hidden pt-lg-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center mb-4">
                        <a href="{{ route('front.home') }}">
                            <img src="{{ asset('images/logo/logo-light.svg') }}" alt="{{ config('georestate.nama') }}" height="38">
                        </a>
                    </div>
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center mt-2 mb-4">
                                <h5 class="text-primary">{{ $judul }}</h5>
                                @if($subjudul)
                                    <p class="text-muted mb-0">{{ $subjudul }}</p>
                                @endif
                            </div>
                            @if(session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif
                            {{ $slot }}
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="mb-0 text-white">
                            <a href="{{ route('login') }}" class="fw-semibold text-white text-decoration-underline">Kembali ke halaman masuk</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('template/admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
