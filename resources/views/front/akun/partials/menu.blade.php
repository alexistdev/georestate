{{-- Menu samping Akun Saya. Variabel: $menuKedua --}}
@php
    $menuAkun = [
        'favorit' => ['route' => 'usr.favorit', 'label' => 'Favorit Saya', 'ikon' => 'far fa-heart'],
        'pertanyaan' => ['route' => 'usr.pertanyaan', 'label' => 'Riwayat Pertanyaan', 'ikon' => 'far fa-comments'],
        'password' => ['route' => 'usr.password', 'label' => 'Ubah Password', 'ikon' => 'fas fa-lock'],
    ];
@endphp
<div class="card custom-card-info custom-card-info-shadow border-0 mb-4">
    <div class="card-body p-0">
        <ul class="list-unstyled mb-0">
            @foreach($menuAkun as $key => $item)
                <li>
                    <a href="{{ route($item['route']) }}"
                       class="d-flex align-items-center gap-2 px-4 py-3 text-decoration-none border-bottom
                              {{ $menuKedua === $key ? 'bg-color-primary text-color-light font-weight-semibold' : 'text-dark' }}">
                        <i class="{{ $item['ikon'] }} fa-fw"></i> {{ $item['label'] }}
                    </a>
                </li>
            @endforeach
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link d-flex align-items-center gap-2 px-4 py-3 text-decoration-none text-dark w-100 text-start">
                        <i class="fas fa-sign-out-alt fa-fw"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
