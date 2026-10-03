<x-front.front-end-template :title="$judul" :main-label="$menuUtama" :secondary-label="$menuKedua">
    <section class="page-header page-header-modern page-header-georestate border-0 m-0">
        <div class="container position-relative z-index-2">
            <div class="row text-center text-md-start py-5">
                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="font-weight-bold text-color-light text-8 mb-0">Agen</h1>
                    <p class="text-color-light opacity-7 mb-0">Agen properti terpercaya di {{ config('georestate.nama') }}</p>
                </div>
                <div class="col-md-4 order-1 order-md-2 align-self-center">
                    <ul class="breadcrumb breadcrumb-light d-block text-md-end text-4 mb-0">
                        <li><a href="{{ route('front.home') }}" class="text-decoration-none">Home</a></li>
                        <li class="text-upeercase active">Agen</li>
                    </ul>
                </div>
            </div>
        </div>
        <svg class="page-header-georestate__gelombang" viewBox="0 0 1440 50" preserveAspectRatio="none" aria-hidden="true">
            <path d="M0 30 C 240 55, 480 5, 720 25 S 1200 50, 1440 15 L1440 50 L0 50 Z" fill="#f3f7fc"/>
        </svg>
    </section>

    <section class="bagian-listing">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-9">
                @forelse($dataAgents as $agent)
                    <div class="row align-items-center pb-4 mb-4 border-bottom">
                        <div class="col-md-4 col-xl-3 mb-3 mb-md-0">
                            <div class="border-radius overflow-hidden">
                                <a href="{{ route('front.agents.detail', $agent) }}">
                                    <img src="{{ $agent->fotoUrl() }}" class="img-fluid w-100" style="aspect-ratio: 1; object-fit: cover;" alt="{{ $agent->hasUser->name }}" onerror="this.onerror=null;this.src='{{ asset(\App\Models\Agent::FOTO_DEFAULT) }}'" />
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8 col-xl-9 ps-lg-4">
                            <h4 class="text-color-dark font-weight-semibold line-height-1 mb-2 text-6">
                                <a href="{{ route('front.agents.detail', $agent) }}" class="text-color-dark text-decoration-none">{{ $agent->hasUser->name }}</a>
                            </h4>
                            <h3 class="text-default text-uppercase text-3 ls-0 mb-2">Listing aktif: {{ $agent->properties_count }}</h3>
                            @if($agent->kecamatan)
                                <p class="text-2 mb-2"><i class="icons icon-location-pin text-color-secondary"></i>
                                    {{ $agent->kecamatan->name }}, {{ $agent->kecamatan->kabupaten->name ?? '' }}</p>
                            @endif
                            @if($agent->about)
                                <p class="text-3-5 mb-3">{{ \Illuminate\Support\Str::limit($agent->about, 220) }}</p>
                            @endif
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('front.agents.detail', $agent) }}" class="btn btn-secondary btn-px-4 btn-py-2 text-2 text-uppercase font-weight-semibold">Lihat Listing</a>
                                @if($agent->whatsappUrl())
                                    <a href="{{ $agent->whatsappUrl() }}" target="_blank" rel="noopener" class="btn btn-outline btn-secondary btn-px-4 btn-py-2 text-2 text-uppercase font-weight-semibold">
                                        <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Belum ada agen yang terdaftar.</p>
                @endforelse

                @if($dataAgents->hasPages())
                    <div class="d-flex pt-3 justify-content-center">
                        {{ $dataAgents->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
            <div class="col-lg-3">
                <div class="card custom-card-info custom-card-info-shadow bg-color-primary text-color-light border-0 mb-4">
                    <div class="card-body bg-transparent p-4 text-center">
                        <h3 class="text-color-light font-weight-semibold text-5 mb-3">Ingin Menjadi Agen?</h3>
                        <p class="text-color-light opacity-7">Pasang listing properti Anda dan jangkau lebih banyak penyewa.</p>
                        <a href="{{ route('register') }}" class="btn btn-light font-weight-semibold text-2 text-uppercase btn-px-4 btn-py-2">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</x-front.front-end-template>
