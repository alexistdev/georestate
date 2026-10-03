<!doctype html>
<html lang="id" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="GeoRestate V.1.0" name="description" />
    <meta content="AlexistDev" name="author" />
    <!-- App favicon -->
    @include('partials.favicon')
    <!-- Layout config Js -->
    <script src="{{asset('template/admin/assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('template/admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('template/admin/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('template/admin/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset('template/admin/assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
</head>

<body>

<!-- auth-page wrapper -->
<div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
    <div class="bg-overlay"></div>
    <!-- auth-page content -->
    <div class="auth-page-content overflow-hidden pt-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4 auth-one-bg h-100">
                                    <div class="bg-overlay"></div>
                                    <div class="position-relative h-100 d-flex flex-column">
                                        <div class="mb-4">
                                            <a href="{{route('login')}}" class="d-block">
                                                <img src="{{ asset('images/logo/logo-light.svg') }}" alt="{{ config('georestate.nama') }}" height="34">
                                            </a>
                                        </div>
                                        <div class="mt-auto">
                                            <div class="mb-3">
                                                <i class="ri-double-quotes-l display-4 text-success"></i>
                                            </div>

                                            <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-indicators">
                                                    <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                    <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                    <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                </div>
                                                <div class="carousel-inner text-center text-white pb-5">
                                                    <div class="carousel-item active">
                                                        <p class="fs-15 fst-italic">" Temukan kos, rumah, dan apartemen sewaan harian, bulanan, atau tahunan. "</p>
                                                    </div>
                                                    <div class="carousel-item">
                                                        <p class="fs-15 fst-italic">" Agen memasang listing, admin meninjau, calon penyewa langsung menghubungi agen. "</p>
                                                    </div>
                                                    <div class="carousel-item">
                                                        <p class="fs-15 fst-italic">" Simpan properti favorit dan pantau status pertanyaan Anda. "</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end carousel -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4">
                                    <div>
                                        <h5 class="text-primary">Selamat Datang Kembali!</h5>
                                        <p class="text-muted">Masuk untuk melanjutkan ke {{ config('georestate.nama') }}.</p>
                                    </div>

                                    @if(session('status'))
                                        <div class="alert alert-info mt-3 mb-0">{{ session('status') }}</div>
                                    @endif

                                    <div class="mt-4">
                                        <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input name="email" type="email" class="form-control" id="email" placeholder="Alamat email" value="{{ old('email') }}" required autofocus>
                                                @error('email')<div class="text-danger mt-2 small">{{ $message }}</div>@enderror
                                            </div>

                                            <div class="mb-3">
                                                @if(\App\Support\Fitur::emailAktif())
                                                    <div class="float-end">
                                                        <a href="{{ route('password.request') }}" class="text-muted">Lupa password?</a>
                                                    </div>
                                                @endif
                                                <label class="form-label" for="password-input">Password</label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input name="password" type="password" class="form-control pe-5 password-input" placeholder="Masukkan password" id="password-input">
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                </div>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="auth-remember-check">
                                                <label class="form-check-label" for="auth-remember-check">Ingat saya</label>
                                            </div>

                                            <div class="mt-4">
                                                <button class="btn btn-success w-100" type="submit">Masuk</button>
                                            </div>

                                        </form>
                                    </div>

                                    <div class="mt-5 text-center">
                                        <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-underline">Daftar</a></p>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0">&copy;
                            {{ date('Y') }} {{ config('georestate.nama') }}. Crafted with <i class="mdi mdi-heart text-danger"></i> by alexistdev
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>
<!-- end auth-page-wrapper -->

<!-- JAVASCRIPT -->
<script src="{{asset('template/admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('template/admin/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('template/admin/assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('template/admin/assets/libs/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('template/admin/assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>

<!-- password-addon init -->
<script src="{{asset('template/admin/assets/js/pages/password-addon.init.js')}}"></script>
</body>

</html>
