<x-front.front-end-template :title="$judul" :main-label="$menuUtama" :secondary-label="$menuKedua">
    <section class="position-relative bg-color-primary" style="min-height: 520px;">
        <div class="container position-relative z-index-1 py-5">
            <div class="row align-items-center" style="min-height: 440px;">
                <div class="col-lg-7 col-xl-6">
                    <div class="card custom-card-info custom-card-info-shadow bg-color-light border-0 box-shadow-1 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="200">
                        <div class="card-body p-4 p-lg-5">
                            <h1 class="text-dark font-weight-bold text-7 line-height-3 mb-2">{{ config('georestate.tagline') }}</h1>
                            <p class="text-3 mb-4">{{ $totalListing }} properti siap disewa harian, bulanan, atau tahunan.</p>

                            <form action="{{ route('front.properties') }}" method="GET" class="form-style-3" id="formCariHome">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <input type="text" name="q" maxlength="100" class="form-control text-default box-shadow-none" placeholder="Cari nama, alamat, atau kata kunci">
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="kategori" class="form-select form-control text-default box-shadow-none" aria-label="Kategori">
                                            <option value="">Semua Kategori</option>
                                            @foreach($dataKategori as $kategori)
                                                <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="periode" class="form-select form-control text-default box-shadow-none" aria-label="Periode sewa">
                                            <option value="">Semua Periode</option>
                                            @foreach(\App\Http\Controllers\Front\PropertiesController::PERIODE as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <select name="provinsi" class="form-select form-control text-default box-shadow-none" aria-label="Provinsi">
                                            <option value="">Semua Provinsi</option>
                                            @foreach($dataProvinsi as $provinsi)
                                                <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 d-grid">
                                        <button type="submit" class="btn btn-secondary font-weight-semibold border-0 text-3 text-uppercase btn-py-3 mt-1">Cari Properti</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5 my-3">
        <div class="row">
            <div class="col-lg-9">
                <h2 class="mb-4">Listing <span class="text-color-secondary">Terbaru</span></h2>

                <div class="row">
                    @forelse($dataTerbaru as $property)
                        <div class="col-12 col-sm-6 col-md-4 pb-4 mb-1">
                            @include('front.partials.property-card', ['property' => $property, 'periode' => null])
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="mb-4">Belum ada listing yang tayang. Kembali lagi nanti, atau <a href="{{ route('register') }}">daftar sebagai agen</a> untuk memasang listing.</p>
                        </div>
                    @endforelse
                </div>

                @if($dataTerbaru->isNotEmpty())
                    <div class="row justify-content-md-center pb-2">
                        <div class="col-md-4">
                            <div class="d-grid gap-2">
                                <a href="{{ route('front.properties') }}" class="btn btn-secondary font-weight-semibold border-0 p-relative text-3 text-uppercase mt-1 btn-px-5 btn-py-3">Lihat Semua</a>
                            </div>
                        </div>
                    </div>
                @endif

                <hr class="my-5">

                <h2 class="mb-3 pb-1">Cari Berdasarkan Kategori</h2>

                <div class="row">
                    @foreach($dataKategori as $kategori)
                        <div class="col-md-4 pb-4 mb-1">
                            <a href="{{ route('front.properties', ['kategori' => $kategori->id]) }}" class="text-decoration-none">
                                <div class="card custom-card-info custom-card-info-shadow border-0 bg-color-secondary h-100">
                                    <div class="card-body text-center py-5">
                                        <strong class="text-color-light font-weight-semibold text-5 d-block mb-2">{{ $kategori->name }}</strong>
                                        <span class="bg-primary text-color-light px-3 py-1 text-1 font-weight-semibold text-uppercase d-inline-block">{{ $kategori->properties_count }} Properti</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-12">
                        <div class="card custom-card-info custom-card-info-shadow bg-color-secondary text-color-light border-0 mb-4">
                            <div class="card-body bg-transparent p-4 text-center">
                                <h3 class="text-color-light font-weight-semibold text-5 mb-2">Punya Properti<br>untuk Disewakan?</h3>
                                <p class="text-color-light opacity-7 mb-3">Pasang listing gratis.</p>
                                <a href="{{ route('register') }}" class="btn btn-light font-weight-semibold text-2 text-uppercase btn-px-4 btn-py-2">Daftar Agen</a>
                            </div>
                        </div>
                    </div>

                    @if($dataAgents->isNotEmpty())
                        <div class="col-12 col-sm-6 col-lg-12">
                            <div class="card custom-card-info custom-card-info-shadow bg-color-primary text-color-light border-0 mb-4">
                                <div class="card-body bg-transparent p-relative p-4 my-2 text-center z-index-1">
                                    <h3 class="text-color-light font-weight-semibold text-5 d-block mb-4">Agen Kami</h3>

                                    <div class="owl-carousel owl-theme dots-light mb-0 pb-0" data-plugin-options="{'items': 1, 'autoplay': true, 'autoplayTimeout': 5000, 'margin': 10}">
                                        @foreach($dataAgents as $agent)
                                            <div>
                                                <a href="{{ route('front.agents.detail', $agent) }}" class="text-decoration-none">
                                                    <img alt="{{ $agent->hasUser->name ?? 'Agen' }}" class="img-fluid rounded-circle m-auto" src="{{ $agent->fotoUrl() }}" style="width: 110px; height: 110px; object-fit: cover;" onerror="this.onerror=null;this.src='{{ asset(\App\Models\Agent::FOTO_DEFAULT) }}'">
                                                    <strong class="text-color-light font-weight-semibold text-4 line-height-5 d-block mt-3 mb-1 text-center">{{ $agent->hasUser->name ?? 'Agen' }}</strong>
                                                </a>
                                                @if($agent->teleponUrl())
                                                    <a class="opacity-7 text-color-light d-block text-center line-height-5 text-3 pb-2" href="{{ $agent->teleponUrl() }}">{{ $agent->phone }}</a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('customJS')
        <script>
            // Jangan kirim parameter kosong agar URL hasil pencarian rapi.
            document.getElementById('formCariHome').addEventListener('submit', function () {
                this.querySelectorAll('input, select').forEach(function (el) {
                    if (!el.value) {
                        el.disabled = true;
                    }
                });
            });
        </script>
    @endpush
</x-front.front-end-template>
