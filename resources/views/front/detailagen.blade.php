<x-front.front-end-template :title="$judul" :main-label="$menuUtama" :secondary-label="$menuKedua">
    <section class="page-header page-header-modern bg-color-primary border-0 m-0">
        <div class="container position-relative z-index-2">
            <div class="row text-center text-md-start py-5">
                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="font-weight-bold text-color-light text-8 mb-0">{{ $agent->hasUser->name }}</h1>
                    <p class="text-color-light opacity-7 mb-0">Agen Properti</p>
                </div>
                <div class="col-md-4 order-1 order-md-2 align-self-center">
                    <ul class="breadcrumb breadcrumb-light d-block text-md-end text-4 mb-0">
                        <li><a href="{{ route('front.home') }}" class="text-decoration-none">Home</a></li>
                        <li><a href="{{ route('front.agents') }}" class="text-decoration-none">Agen</a></li>
                        <li class="text-upeercase active">Profil</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5 my-3">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="card custom-card-info custom-card-info-shadow border-0">
                    <div class="card-body p-4 text-center">
                        <img src="{{ $agent->fotoUrl() }}" alt="{{ $agent->hasUser->name }}" class="img-fluid rounded-circle mb-3" style="max-width: 140px; aspect-ratio: 1; object-fit: cover;" onerror="this.onerror=null;this.src='{{ asset(\App\Models\Agent::FOTO_DEFAULT) }}'">
                        <h4 class="text-5 mb-1">{{ $agent->hasUser->name }}</h4>
                        @if($agent->kecamatan)
                            <p class="text-2 mb-2">{{ $agent->kecamatan->name }}, {{ $agent->kecamatan->kabupaten->name ?? '' }}</p>
                        @endif
                        @if($agent->phone)
                            <p class="mb-3"><a href="{{ $agent->teleponUrl() }}">{{ $agent->phone }}</a></p>
                        @endif
                        <div class="d-grid gap-2">
                            @if($agent->whatsappUrl())
                                <a href="{{ $agent->whatsappUrl() }}" target="_blank" rel="noopener" class="btn btn-secondary font-weight-semibold text-2 text-uppercase btn-py-2">
                                    <i class="fab fa-whatsapp me-1"></i> Chat WhatsApp
                                </a>
                            @endif
                        </div>
                        @if($agent->about)
                            <hr>
                            <p class="text-2 text-start mb-0">{!! nl2br(e($agent->about)) !!}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <h2 class="mb-4 text-6">Listing dari <span class="text-color-secondary">{{ $agent->hasUser->name }}</span> ({{ $dataProperties->total() }})</h2>
                <div class="row">
                    @forelse($dataProperties as $property)
                        <div class="col-12 col-sm-6 col-lg-4 pb-4 mb-1">
                            @include('front.partials.property-card', ['property' => $property, 'periode' => null])
                        </div>
                    @empty
                        <div class="col-12">
                            <p>Agen ini belum memiliki listing yang tayang.</p>
                        </div>
                    @endforelse
                </div>
                @if($dataProperties->hasPages())
                    <div class="d-flex pt-3 justify-content-center">
                        {{ $dataProperties->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-front.front-end-template>
