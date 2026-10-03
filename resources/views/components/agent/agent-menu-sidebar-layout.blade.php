<div>
    <ul class="navbar-nav" id="navbar-nav">
        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
        <li class="nav-item">
            <a class="nav-link menu-link @if($menuUtama == "dashboard") active @endif" href="{{ route('agn.dashboard') }}">
                <i class="bx bxs-dashboard"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link menu-link @if($menuUtama == "dataku") active @endif" href="{{ route('agn.lists') }}">
                <i class="bx bx-building-house"></i> <span>Listing Saya</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link menu-link @if($menuUtama == "pertanyaan") active @endif" href="{{ route('agn.pertanyaan') }}">
                <i class="bx bx-message-square-dots"></i> <span>Pertanyaan</span>
                @if($jumlahPertanyaanBaru > 0)
                    <span class="badge badge-pill bg-danger">{{ $jumlahPertanyaanBaru }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link menu-link @if($menuUtama == "profil") active @endif" href="{{ route('agn.profil') }}">
                <i class="bx bx-user-circle"></i> <span>Profil Saya</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link menu-link" href="{{ route('front.home') }}" target="_blank" rel="noopener">
                <i class="bx bx-globe"></i> <span>Lihat Website</span>
            </a>
        </li>
    </ul>
</div>
