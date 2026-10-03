{{--
    Tombol ❤ favorit.
    Variabel: $property, $varian ('kartu' = ikon bulat di pojok kartu, 'detail' = tombol berlabel)
    Tamu → login lalu kembali ke properti; pencari properti → simpan/hapus; agen & admin → tidak ditampilkan.
--}}
@php
    $pengguna = auth()->user();
    $bolehFavorit = $pengguna === null || $pengguna->hasRole(\App\Enums\Role::User);
    $sudahFavorit = $pengguna !== null && in_array($property->id, $pengguna->favoritIds(), true);
    $label = $sudahFavorit ? 'Hapus dari favorit' : 'Simpan ke favorit';
@endphp

@if($bolehFavorit)
    @once
        @push('customCSS')
            <style>
                .tombol-favorit {
                    display: inline-flex; align-items: center; justify-content: center; gap: 6px;
                    border: 1px solid rgba(0, 0, 0, .08); background: #fff; color: #c0392b;
                    border-radius: 999px; cursor: pointer; transition: transform .15s ease, box-shadow .15s ease;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, .12); text-decoration: none;
                }
                .tombol-favorit:hover { transform: scale(1.06); color: #a93226; }
                .tombol-favorit--kartu { position: absolute; top: 14px; right: 14px; z-index: 3; width: 38px; height: 38px; font-size: 16px; }
                .tombol-favorit--detail { padding: 8px 18px; font-weight: 600; font-size: 13px; text-transform: uppercase; }
            </style>
        @endpush
    @endonce

    @if($pengguna)
        <form method="POST" action="{{ route('front.favorit.toggle', $property->slug) }}" class="d-inline">
            @csrf
            <button type="submit" class="tombol-favorit tombol-favorit--{{ $varian }}" title="{{ $label }}" aria-label="{{ $label }}">
                <i class="{{ $sudahFavorit ? 'fas' : 'far' }} fa-heart"></i>
                @if($varian === 'detail')<span>{{ $sudahFavorit ? 'Tersimpan di Favorit' : 'Simpan Favorit' }}</span>@endif
            </button>
        </form>
    @else
        <a href="{{ route('front.favorit.masuk', $property->slug) }}" class="tombol-favorit tombol-favorit--{{ $varian }}"
           title="Masuk untuk menyimpan favorit" aria-label="Masuk untuk menyimpan favorit">
            <i class="far fa-heart"></i>
            @if($varian === 'detail')<span>Simpan Favorit</span>@endif
        </a>
    @endif
@endif
