{{--
    Peta baca-saja satu titik lokasi properti.
    Pemakaian: <x-peta-lokasi :property="$property" tinggi="320px" />
    Jika listing belum punya koordinat, komponen tidak menampilkan apa-apa (cek dulu dengan punyaKoordinat()).
--}}
@props(['property', 'tinggi' => '320px'])

@if($property->punyaKoordinat())
    @include('partials.leaflet')
    <div {{ $attributes->merge(['class' => 'peta-georestate']) }}
         style="height: {{ $tinggi }};"
         data-lat="{{ $property->latitude }}" data-lng="{{ $property->longitude }}"
         data-judul="{{ $property->name }}"
         role="img" aria-label="Peta lokasi {{ $property->name }}"></div>
    <div class="mt-2" style="font-size: .9rem;">
        <a href="{{ $property->urlPetunjukArah() }}" target="_blank" rel="noopener">Petunjuk arah (Google Maps)</a>
        &middot;
        <a href="https://www.openstreetmap.org/?mlat={{ $property->latitude }}&amp;mlon={{ $property->longitude }}#map=17/{{ $property->latitude }}/{{ $property->longitude }}" target="_blank" rel="noopener">Buka di OpenStreetMap</a>
    </div>
@endif
