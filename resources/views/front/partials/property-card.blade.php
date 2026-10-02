{{--
    Kartu listing untuk halaman publik.
    Variabel: $property (dengan relasi kecamatan, kategori, gambarUtama), $periode (opsional, periode yang difilter)
--}}
@php($harga = $property->hargaUtama($periode ?? null))
<div class="card custom-card-info custom-card-info-shadow border-0 h-100">
    <div class="card-body overflow-hidden p-relative z-index-1">
        <a href="{{ route('front.properties.detail', $property->slug) }}" class="text-decoration-none">
            <span class="custom-card-info-type bg-primary text-color-light px-3 py-1 text-1 font-weight-semibold text-uppercase d-inline-block p-absolute top-8 left-8">
                {{ $property->kategori->name ?? 'Properti' }}
            </span>
            <span class="custom-card-info-img d-block">
                <img src="{{ $property->gambarUtamaUrl() }}" alt="{{ $property->name }}" class="img-fluid w-100"
                     style="aspect-ratio: 3 / 2; object-fit: cover;" loading="lazy"
                     onerror="this.onerror=null;this.src='{{ \App\Models\Gambar::defaultUrl() }}'">
            </span>
            <span class="custom-card-info-header d-block p-relative">
                @if($harga)
                    <strong class="text-dark text-4">{{ $harga[0] }}</strong>
                    <span class="text-default text-2">/ {{ $harga[1] }}</span>
                @else
                    <strong class="text-dark text-4">Hubungi Agen</strong>
                @endif
                <img width="27" height="27" src="{{ asset('template/frontend/img/demos/real-estate/icons/arrow-right.svg') }}" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-secondary custom-card-info-arrow p-absolute top-5 mt-2 me-3'}" />
            </span>
            <span class="custom-card-info-content d-block">
                <h4 class="text-dark mb-1 text-4 line-height-3">{{ \Illuminate\Support\Str::limit($property->name, 60) }}</h4>
                <span class="d-block text-default text-2 mb-2">
                    <i class="icons icon-location-pin text-color-secondary"></i>
                    {{ $property->kecamatan?->name }}{{ $property->kecamatan?->kabupaten ? ', '.$property->kecamatan->kabupaten->name : '' }}
                </span>
                <ul class="list list-unstyled list-inline mb-0">
                    <li class="list-inline-item me-2 mb-0">
                        <strong class="text-default text-uppercase text-2">K. Tidur: {{ $property->beds }}</strong>
                    </li>
                    <li class="list-inline-item me-2 mb-0">
                        <strong class="text-default text-uppercase text-2">K. Mandi: {{ $property->baths }}</strong>
                    </li>
                    <li class="list-inline-item me-0 mb-0">
                        <strong class="text-default text-uppercase text-2">{{ $property->lt }}×{{ $property->lb }} m</strong>
                    </li>
                </ul>
            </span>
        </a>
    </div>
</div>
