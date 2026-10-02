<x-front.front-end-template :title="$judul" :main-label="$menuUtama" :secondary-label="$menuKedua">
    <section class="page-header page-header-modern bg-color-primary border-0 m-0">
        <div class="container position-relative z-index-2">
            <div class="row text-center text-md-start py-5">
                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="font-weight-bold text-color-light text-8 mb-0">Cari Properti</h1>
                    <p class="text-color-light opacity-7 mb-0">Kos, kamar, rumah, apartemen, dan ruko yang siap disewa</p>
                </div>
                <div class="col-md-4 order-1 order-md-2 align-self-center">
                    <ul class="breadcrumb breadcrumb-light d-block text-md-end text-4 mb-0">
                        <li><a href="{{ route('front.home') }}" class="text-decoration-none">Home</a></li>
                        <li class="text-upeercase active">Properti</li>
                    </ul>
                </div>
            </div>
        </div>

        <form class="form-style-3 pb-5" id="formFilter" action="{{ route('front.properties') }}" method="GET">
            <div class="container">
                <div class="row g-2">
                    <div class="col-lg-4">
                        <input type="text" name="q" value="{{ $filter['q'] ?? '' }}" maxlength="100"
                               class="form-control text-default box-shadow-none" placeholder="Cari nama, alamat, atau kata kunci">
                    </div>
                    <div class="col-6 col-lg-2">
                        <select class="form-select form-control text-default box-shadow-none" name="kategori" aria-label="Kategori">
                            <option value="">Semua Kategori</option>
                            @foreach($dataKategori as $kategori)
                                <option value="{{ $kategori->id }}" @selected(($filter['kategori'] ?? null) == $kategori->id)>{{ $kategori->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-lg-2">
                        <select class="form-select form-control text-default box-shadow-none" name="periode" aria-label="Periode sewa">
                            <option value="">Semua Periode</option>
                            @foreach(\App\Http\Controllers\Front\PropertiesController::PERIODE as $value => $label)
                                <option value="{{ $value }}" @selected(($filter['periode'] ?? null) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-lg-2">
                        <input type="number" min="1" name="harga_min" value="{{ $filter['harga_min'] ?? '' }}"
                               class="form-control text-default box-shadow-none" placeholder="Harga min (Rp)">
                    </div>
                    <div class="col-6 col-lg-2">
                        <input type="number" min="1" name="harga_max" value="{{ $filter['harga_max'] ?? '' }}"
                               class="form-control text-default box-shadow-none" placeholder="Harga maks (Rp)">
                    </div>

                    <div class="col-12 col-md-4 col-lg-3">
                        <select class="form-select form-control text-default box-shadow-none" name="provinsi" id="filterProvinsi" aria-label="Provinsi">
                            <option value="">Semua Provinsi</option>
                            @foreach($dataProvinsi as $provinsi)
                                <option value="{{ $provinsi->id }}" @selected(($filter['provinsi'] ?? null) == $provinsi->id)>{{ $provinsi->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <select class="form-select form-control text-default box-shadow-none" name="kabupaten" id="filterKabupaten" aria-label="Kabupaten">
                            <option value="">Semua Kabupaten/Kota</option>
                            @foreach($dataKabupaten as $kabupaten)
                                <option value="{{ $kabupaten->id }}" @selected(($filter['kabupaten'] ?? null) == $kabupaten->id)>{{ $kabupaten->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <select class="form-select form-control text-default box-shadow-none" name="kecamatan" id="filterKecamatan" aria-label="Kecamatan">
                            <option value="">Semua Kecamatan</option>
                            @foreach($dataKecamatan as $kecamatan)
                                <option value="{{ $kecamatan->id }}" @selected(($filter['kecamatan'] ?? null) == $kecamatan->id)>{{ $kecamatan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-lg-2">
                        <select class="form-select form-control text-default box-shadow-none" name="kamar" aria-label="Kamar tidur">
                            <option value="">Kamar Tidur</option>
                            @foreach([1, 2, 3, 4] as $kamar)
                                <option value="{{ $kamar }}" @selected(($filter['kamar'] ?? null) == $kamar)>Min. {{ $kamar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-lg-2">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-secondary custom-btn-search-page-header font-weight-semibold border-0 text-1 text-uppercase btn-px-4 btn-py-2">Cari</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="urut" value="{{ $filter['urut'] ?? '' }}" id="filterUrut">
            </div>
        </form>
    </section>

    <div class="container py-5 my-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
            <h2 class="mb-0 text-6">
                {{ $dataProperties->total() }} <span class="text-color-secondary">properti</span> ditemukan
            </h2>
            <div class="d-flex align-items-center gap-2">
                @if(!empty($filter))
                    <a href="{{ route('front.properties') }}" class="text-2 me-2">Reset filter</a>
                @endif
                <label for="pilihUrut" class="text-2 mb-0">Urutkan:</label>
                <select id="pilihUrut" class="form-select form-select-sm w-auto">
                    @foreach(\App\Http\Controllers\Front\PropertiesController::URUTAN as $value => $label)
                        <option value="{{ $value }}" @selected(($filter['urut'] ?? 'terbaru') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if(isset($filter['harga_min']) || isset($filter['harga_max']) || in_array($filter['urut'] ?? null, ['termurah', 'termahal'], true))
            @unless(isset($filter['periode']))
                <p class="text-2 mt-n3 mb-4">Filter dan urutan harga memakai harga <strong>bulanan</strong>. Pilih periode untuk mengubahnya.</p>
            @endunless
        @endif

        <div class="row">
            @forelse($dataProperties as $property)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pb-4 mb-1">
                    @include('front.partials.property-card', ['property' => $property, 'periode' => $filter['periode'] ?? null])
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="icons icon-magnifier text-color-secondary text-10 d-block mb-3"></i>
                        <h3 class="text-5 mb-2">Belum ada properti yang cocok</h3>
                        <p class="mb-3">Coba ubah atau kurangi filter pencarian Anda.</p>
                        <a href="{{ route('front.properties') }}" class="btn btn-secondary btn-px-4">Lihat Semua Properti</a>
                    </div>
                </div>
            @endforelse
        </div>

        @if($dataProperties->hasPages())
            <div class="d-flex pt-3 justify-content-center">
                {{ $dataProperties->onEachSide(1)->links() }}
            </div>
        @endif
    </div>

    <section class="section section-height-3 bg-secondary border-0 m-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9 text-center text-lg-start mb-4 mb-lg-0">
                    <h2 class="mb-4 text-color-light mb-0">Punya properti untuk <span class="font-weight-extra-bold">disewakan</span>?</h2>
                    <p class="font-weight-semibold text-color-light text-4 opacity-7 mb-0">Daftar sebagai agen dan pasang listing Anda gratis.</p>
                </div>
                <div class="col-lg-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('register') }}" class="btn btn-primary font-weight-semibold border-0 text-3 text-uppercase mt-4 btn-py-3">Daftar Agen</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('customJS')
        <script>
            (function () {
                const form = document.getElementById('formFilter');
                const provinsi = document.getElementById('filterProvinsi');
                const kabupaten = document.getElementById('filterKabupaten');
                const kecamatan = document.getElementById('filterKecamatan');
                const urlKabupaten = @json(route('front.wilayah.kabupaten', '__ID__'));
                const urlKecamatan = @json(route('front.wilayah.kecamatan', '__ID__'));

                function kosongkan(select) {
                    select.length = 1;
                }

                function isi(select, url) {
                    fetch(url, {headers: {'Accept': 'application/json'}})
                        .then(response => response.ok ? response.json() : [])
                        .then(data => data.forEach(item => select.add(new Option(item.name, item.id))));
                }

                provinsi.addEventListener('change', function () {
                    kosongkan(kabupaten);
                    kosongkan(kecamatan);
                    if (this.value) {
                        isi(kabupaten, urlKabupaten.replace('__ID__', this.value));
                    }
                });

                kabupaten.addEventListener('change', function () {
                    kosongkan(kecamatan);
                    if (this.value) {
                        isi(kecamatan, urlKecamatan.replace('__ID__', this.value));
                    }
                });

                document.getElementById('pilihUrut').addEventListener('change', function () {
                    document.getElementById('filterUrut').value = this.value;
                    form.requestSubmit();
                });

                // Jangan kirim parameter kosong agar URL tetap rapi.
                form.addEventListener('submit', function () {
                    form.querySelectorAll('input, select').forEach(function (el) {
                        if (!el.value) {
                            el.disabled = true;
                        }
                    });
                });
            })();
        </script>
    @endpush
</x-front.front-end-template>
