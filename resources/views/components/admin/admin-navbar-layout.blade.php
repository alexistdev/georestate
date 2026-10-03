<div>
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                @php($isSuper = auth()->user()?->hasRole(\App\Enums\Role::Super))
                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->routeIs('adm.dashboard', 'sup.dashboard')) active @endif" href="{{ route($isSuper ? 'sup.dashboard' : 'adm.dashboard') }}">
                        <i class="bx bxs-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->routeIs('adm.listing*')) active @endif" href="{{ route('adm.listing') }}">
                        <i class="bx bx-building-house"></i> <span>Moderasi Listing</span>
                        @if($jumlahPending > 0)
                            <span class="badge badge-pill bg-warning">{{ $jumlahPending }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->routeIs('adm.pertanyaan*')) active @endif" href="{{ route('adm.pertanyaan') }}">
                        <i class="bx bx-message-square-dots"></i> <span>Pertanyaan ke Agen</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->routeIs('adm.pesan*')) active @endif" href="{{ route('adm.pesan') }}">
                        <i class="bx bx-envelope"></i> <span>Pesan Kontak</span>
                        @if($jumlahPesanBaru > 0)
                            <span class="badge badge-pill bg-danger">{{ $jumlahPesanBaru }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->routeIs('adm.agent*', 'adm.user*')) active @endif" href="#sidebarPengguna" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPengguna">
                        <i class="bx bx-user"></i> <span>Pengguna</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPengguna">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('adm.agent') }}" class="nav-link"> Agen </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('adm.user') }}" class="nav-link"> Pencari Properti </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->routeIs('adm.kategori*', 'adm.fasilitas*', 'adm.disctrict*')) active @endif" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="bx bx-layer"></i> <span data-key="t-apps">Master Data</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('adm.kategori') }}" class="nav-link"> Kategori </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('adm.fasilitas') }}" class="nav-link"> Fasilitas </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('adm.disctrict')}}" class="nav-link" data-key="t-chat"> Wilayah </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @if($isSuper)
                    <li class="nav-item">
                        <a class="nav-link menu-link @if(request()->routeIs('sup.admin*')) active @endif" href="{{ route('sup.admin') }}">
                            <i class="bx bx-shield-quarter"></i> <span>Kelola Admin</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
