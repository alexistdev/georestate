<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="GeoRestate V.1.0" name="description" />
    <meta content="AlexistDev" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('template/admin/assets/images/favicon.ico')}}">
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
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Buat Akun Baru</h5>
                                <p class="text-muted">Daftar sebagai pencari properti atau agen di GeoRestate.</p>
                            </div>

                            <div class="p-2 mt-4">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">Jenis Akun <span class="text-danger">*</span></label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="role" id="role-user" value="user" @checked(old('role', 'user') === 'user')>
                                                <label class="form-check-label" for="role-user">Pencari Properti</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="role" id="role-agen" value="agen" @checked(old('role') === 'agen')>
                                                <label class="form-check-label" for="role-agen">Agen Properti</label>
                                            </div>
                                        </div>
                                        @error('role')
                                        <div class="text-sm text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nama lengkap" value="{{ old('name') }}" required autofocus autocomplete="name">
                                        @error('name')
                                        <div class="text-sm text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="username">
                                        @error('email')
                                        <div class="text-sm text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3" id="phone-group" @if(old('role') !== 'agen') style="display: none;" @endif>
                                        <label for="phone" class="form-label">No. Telepon / WhatsApp <span class="text-danger">*</span></label>
                                        <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
                                        @error('phone')
                                        <div class="text-sm text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" required autocomplete="new-password">
                                        @error('password')
                                        <div class="text-sm text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                                        <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Ulangi password" required autocomplete="new-password">
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">Daftar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="mb-0 text-white">Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold text-white text-decoration-underline">Masuk</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end auth page content -->
</div>
<!-- end auth-page-wrapper -->

<!-- JAVASCRIPT -->
<script src="{{asset('template/admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script>
    document.querySelectorAll('input[name="role"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            document.getElementById('phone-group').style.display = this.value === 'agen' ? '' : 'none';
        });
    });
</script>
</body>

</html>
