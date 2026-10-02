{{--
    KERANGKA PETA LOKASI (belum aktif).
    Data: kolom properties.latitude & properties.longitude (nullable, belum diisi lewat form agen).

    TODO (dikerjakan setelah fitur utama selesai, lihat docs/ANALISIS.md):
    1. Tambah input koordinat / pilih titik peta di form listing agen.
    2. Muat library peta (mis. Leaflet + OpenStreetMap) lewat @push('customCSS') dan @push('customJS').
    3. Render marker di #petaLokasi memakai data-lat & data-lng.

    Variabel: $property
--}}
<div id="map">
    <h3 class="mt-5 mb-3">Lokasi</h3>
    <div id="petaLokasi"
         class="border-radius overflow-hidden mt-0 mb-4 bg-color-grey d-flex align-items-center justify-content-center text-center p-4"
         style="min-height: 240px;"
         @if($property->punyaKoordinat())
             data-lat="{{ $property->latitude }}" data-lng="{{ $property->longitude }}"
         @endif>
        <div>
            <i class="icons icon-map text-color-secondary text-8 d-block mb-2"></i>
            <strong class="d-block text-dark">{{ $property->lokasi() ?: 'Lokasi belum diatur' }}</strong>
            <span class="text-2">Peta lokasi akan segera tersedia.</span>
        </div>
    </div>
</div>
