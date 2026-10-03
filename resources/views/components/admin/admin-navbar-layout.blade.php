<div>
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->routeIs('adm.dashboard')) active @endif" href="{{ route('adm.dashboard') }}">
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
                    <a class="nav-link menu-link @if(request()->routeIs('adm.pesan*')) active @endif" href="{{ route('adm.pesan') }}">
                        <i class="bx bx-envelope"></i> <span>Pesan Kontak</span>
                        @if($jumlahPesanBaru > 0)
                            <span class="badge badge-pill bg-danger">{{ $jumlahPesanBaru }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="bx bx-layer"></i> <span data-key="t-apps">Master Data</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('adm.agent')}}" class="nav-link" data-key="t-calendar"> Agent </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('adm.disctrict')}}" class="nav-link" data-key="t-chat"> Wilayah </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
