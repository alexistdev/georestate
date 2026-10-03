<div>
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box horizontal-logo">
                        <a href="{{route('agn.dashboard')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('images/logo/logo-icon.svg') }}" alt="{{ config('georestate.nama') }}" height="26">
                        </span>
                            <span class="logo-lg">
                            <img src="{{ asset('images/logo/logo-dark.svg') }}" alt="{{ config('georestate.nama') }}" height="28">
                        </span>
                        </a>

                        <a href="{{route('agn.dashboard')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('images/logo/logo-icon.svg') }}" alt="{{ config('georestate.nama') }}" height="26">
                        </span>
                            <span class="logo-lg">
                            <img src="{{ asset('images/logo/logo-light.svg') }}" alt="{{ config('georestate.nama') }}" height="28">
                        </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    </button>
                </div>

                <div class="d-flex align-items-center">
                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen" title="Layar penuh" aria-label="Layar penuh">
                            <i class='bx bx-fullscreen fs-22'></i>
                        </button>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode" title="Mode gelap/terang" aria-label="Mode gelap/terang">
                            <i class='bx bx-moon fs-22'></i>
                        </button>
                    </div>

                    @php($penggunaLogin = auth()->user())
                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" style="object-fit: cover;"
                                 src="{{ $penggunaLogin?->hasAgent?->fotoUrl() ?? asset(\App\Models\Agent::FOTO_DEFAULT) }}" alt=""
                                 onerror="this.onerror=null;this.src='{{ asset(\App\Models\Agent::FOTO_DEFAULT) }}'">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ $penggunaLogin?->name }}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{ $penggunaLogin?->roleEnum()?->label() }}</span>
                            </span>
                        </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <h6 class="dropdown-header">{{ $penggunaLogin?->email }}</h6>
                            <a class="dropdown-item" href="{{ route('agn.profil') }}"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profil Saya</span></a>
                            <a class="dropdown-item" href="{{ route('agn.profil') }}#ubah-password"><i class="mdi mdi-lock-reset text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Ubah Password</span></a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Logout</span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>
