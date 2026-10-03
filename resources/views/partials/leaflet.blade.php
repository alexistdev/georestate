{{--
    Aset Leaflet + konfigurasi peta (dimuat sekali per halaman).
    Layout harus punya @stack('customCSS') dan @stack('customJS').
--}}
@once
    @push('customCSS')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css"
              integrity="sha512-Zcn6bjR/8RZbLEpLIeOwNtzREBAJnUKESxces60Mpoj+2okopSAcSUIUOseddDm0cxnGQzxIR7vJgsLZbdLE3w==" crossorigin="anonymous">
        <style>
            .peta-georestate { width: 100%; border-radius: 8px; z-index: 0; }
        </style>
    @endpush
    @push('customJS')
        @php
            $konfigPeta = [
                'tileUrl' => config('georestate.peta.tile_url'),
                'atribusi' => config('georestate.peta.atribusi'),
                'pusat' => config('georestate.peta.pusat'),
                'zoom' => config('georestate.peta.zoom'),
            ];
        @endphp
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"
                integrity="sha512-BwHfrr4c9kmRkLw6iXFdzcdWV/PGkVgiIyIWLLlTSXzWQzxuSg4DiQUCpauz/EWjgk5TYQqX/kvn9pG1NpYfqg==" crossorigin="anonymous"></script>
        <script>
            window.GeoPeta = {
                config: @json($konfigPeta),
                /** Buat peta Leaflet di elemen, dengan tile dari config. */
                buat: function (el, opsi) {
                    let peta = L.map(el, Object.assign({scrollWheelZoom: false}, opsi || {}));
                    L.tileLayer(this.config.tileUrl, {maxZoom: 19, attribution: this.config.atribusi}).addTo(peta);
                    // Hitung ulang ukuran setelah layout/font selesai dimuat (mencegah area abu-abu).
                    window.addEventListener('load', function () { peta.invalidateSize(); });
                    if (window.ResizeObserver) {
                        new ResizeObserver(function () { peta.invalidateSize(); }).observe(peta.getContainer());
                    }
                    return peta;
                }
            };

            /** Peta baca-saja: semua elemen .peta-georestate[data-lat][data-lng] */
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.peta-georestate[data-lat][data-lng]').forEach(function (el) {
                    let titik = [parseFloat(el.dataset.lat), parseFloat(el.dataset.lng)];
                    let peta = GeoPeta.buat(el).setView(titik, 16);
                    let marker = L.marker(titik).addTo(peta);
                    if (el.dataset.judul) {
                        marker.bindPopup(document.createTextNode(el.dataset.judul));
                    }
                });
            });
        </script>
    @endpush
@endonce
