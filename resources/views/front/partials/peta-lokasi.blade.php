{{--
    Peta lokasi di halaman detail properti (Leaflet + OpenStreetMap).
    Titik diisi agen di form listing; jika belum ada, tampil alamat saja.
    Variabel: $property
--}}
<div id="map">
    <h3 class="mt-5 mb-3">Lokasi</h3>
    @if($property->punyaKoordinat())
        <x-peta-lokasi :property="$property" tinggi="360px" class="mb-1" id="petaLokasi" />
        <p class="text-2 mt-2 mb-4">{{ collect([$property->address, $property->lokasi()])->filter()->implode(', ') }}</p>
    @else
        <div id="petaLokasi"
             class="border-radius overflow-hidden mt-0 mb-4 bg-color-grey d-flex align-items-center justify-content-center text-center p-4"
             style="min-height: 160px;">
            <div>
                <i class="icons icon-map text-color-secondary text-8 d-block mb-2"></i>
                <strong class="d-block text-dark">{{ $property->lokasi() ?: 'Lokasi belum diatur' }}</strong>
                <span class="text-2">Agen belum menandai titik lokasi di peta. Tanyakan detail lokasi kepada agen.</span>
            </div>
        </div>
    @endif
</div>
