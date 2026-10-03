<div>
    @php($kontak = config('georestate.kontak'))
    <header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 70}">
        <div class="header-body border-top-0">
            <div class="header-top header-top-georestate">
                <div class="container">
                    <div class="header-row py-2">
                        <div class="header-column justify-content-start">
                            <div class="header-row">
                                <nav class="header-nav-top">
                                    <ul class="list list-unstyled list-inline mb-0">
                                        @if(!$kontak['telepon'] && !$kontak['alamat'] && !$kontak['email'])
                                            <li class="list-inline-item mb-0 d-none d-md-inline-block">
                                                <span class="topbar-teks"><i class="fas fa-map-marker-alt me-2"></i>Sewa kos, kamar, rumah &amp; apartemen di seluruh Indonesia</span>
                                            </li>
                                        @endif
                                        @if($kontak['telepon'])
                                            <li class="list-inline-item me-4 mb-0">
                                                <i class="icons icon-phone topbar-ikon me-1"></i>
                                                <a href="tel:{{ preg_replace('/[^\d+]/', '', $kontak['telepon']) }}" class="topbar-teks text-decoration-none">
                                                    {{ $kontak['telepon'] }}
                                                </a>
                                            </li>
                                        @endif
                                        @if($kontak['alamat'])
                                            <li class="list-inline-item me-4 mb-0 d-none d-lg-inline-block">
                                                <i class="icons icon-location-pin topbar-ikon me-1"></i>
                                                <span class="topbar-teks">{{ \Illuminate\Support\Str::limit($kontak['alamat'], 60) }}</span>
                                            </li>
                                        @endif
                                        @if($kontak['email'])
                                            <li class="list-inline-item me-4 mb-0 d-none d-md-inline-block">
                                                <i class="icons icon-envelope topbar-ikon me-1"></i>
                                                <a href="mailto:{{ $kontak['email'] }}" class="topbar-teks text-decoration-none">
                                                    {{ $kontak['email'] }}
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="header-column justify-content-end">
                            <div class="header-row">
                                <div class="topbar-akun">
                                    @auth
                                        @if(auth()->user()->hasRole(\App\Enums\Role::User))
                                            <a href="{{ route('usr.favorit') }}" class="topbar-tautan"><i class="far fa-user-circle"></i> Akun Saya</a>
                                        @else
                                            <a href="{{ route('dashboard') }}" class="topbar-tautan"><i class="fas fa-th-large"></i> Dashboard</a>
                                        @endif
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="topbar-tombol topbar-tombol--garis"><i class="fas fa-sign-out-alt"></i> Keluar</button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="topbar-tautan"><i class="fas fa-sign-in-alt"></i> Masuk</a>
                                        <a href="{{ route('register') }}" class="topbar-tombol"><i class="fas fa-user-plus"></i> Daftar Gratis</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-container container">
                <div class="header-row">
                    <div class="header-column">
                        <div class="header-row">
                            <div class="header-logo">
                                <a href="{{ route('front.home') }}">
                                    <img alt="{{ config('georestate.nama') }}" width="184" height="42" data-sticky-width="158" data-sticky-height="36" src="{{ asset('images/logo/logo-dark.svg') }}">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="header-column justify-content-end">
                        <div class="header-row">
                            <div class="header-nav header-nav-links header-nav-georestate header-nav-click-to-open order-2 order-lg-1">
                                <div class="header-nav-main header-nav-main-square header-nav-main-dropdown-no-borders header-nav-main-dropdown-modern header-nav-main-effect-2 header-nav-main-sub-effect-1">
                                    <nav class="collapse">
                                        <ul class="nav nav-pills" id="mainNav">
                                            <li>
                                                <a class="nav-link @if($mainLabel == "home") active @endif" href="{{ route('front.home') }}">
                                                    Home
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link @if($mainLabel == "properties") active @endif" href="{{ route('front.properties') }}">
                                                    Properti
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link @if($mainLabel == "agen") active @endif" href="{{ route('front.agents') }}">
                                                    Agen
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link @if($mainLabel == "about") active @endif" href="{{ route('front.about') }}">
                                                    Tentang
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link @if($mainLabel == "contact") active @endif" href="{{ route('front.contact') }}">
                                                    Kontak
                                                </a>
                                            </li>
                                            <li class="dropdown dropdown-mega" id="headerSearchProperties">
                                                <a class="nav-link dropdown-toggle nav-link-cari" href="#">
                                                    <i class="fas fa-search me-2"></i> Cari
                                                </a>
                                                <ul class="dropdown-menu custom-fullwidth-dropdown-menu ms-0">
                                                    <li>
                                                        <div class="dropdown-mega-content mt-3 mt-lg-0">
                                                            <form class="form-style-3" id="formCariHeader" action="{{ route('front.properties') }}" method="GET">
                                                                <div class="container p-0">
                                                                    <div class="row">
                                                                        <div class="col-lg-9 mb-2 mb-lg-0">
                                                                            <label for="cariHeader">KATA KUNCI</label>
                                                                            <input type="text" name="q" id="cariHeader" maxlength="100" required
                                                                                   class="form-control text-default box-shadow-none" placeholder="Nama properti, alamat, atau kata kunci">
                                                                        </div>
                                                                        <div class="col-lg-3 mb-2 mb-lg-0">
                                                                            <div class="d-grid gap-2">
                                                                                <input type="submit" value="Cari" class="btn btn-secondary font-weight-semibold border-0 p-relative bottom-3 text-1 text-uppercase mt-1 mt-lg-4 btn-px-4 btn-py-2">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                <button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
                                    <i class="fas fa-bars"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <script>
        /* Dropdown "Cari" dibuka dengan klik (mode header-nav-click-to-open bawaan tema):
           fokuskan kolom pencarian saat terbuka, tutup dengan Esc. */
        document.addEventListener('DOMContentLoaded', function () {
            const menuCari = document.getElementById('headerSearchProperties');
            if (!menuCari) {
                return;
            }
            menuCari.querySelector('.nav-link-cari').addEventListener('click', function () {
                setTimeout(function () {
                    if (menuCari.classList.contains('open')) {
                        document.getElementById('cariHeader').focus();
                    }
                }, 50);
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && menuCari.classList.contains('open')) {
                    menuCari.classList.remove('open');
                    document.querySelectorAll('#mainNav a.current-page-active').forEach(function (a) { a.classList.add('active'); });
                    menuCari.querySelector('.nav-link-cari').classList.remove('active');
                }
            });
        });
    </script>
</div>
