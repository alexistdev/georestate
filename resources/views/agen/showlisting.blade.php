<x-agent.agent-template :title="$title" :menu-utama="$menuUtama" :menu-kedua="$menuKedua">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Detail Listing</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('agn.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('agn.lists')}}">My Listing</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($property->status === \App\Enums\PropertyStatus::Rejected)
        <div class="alert alert-danger">
            <strong>Listing ditolak admin.</strong>
            @if($property->alasan_penolakan)
                Alasan: {{ $property->alasan_penolakan }}
            @endif
            <br>Silahkan perbaiki listing lalu simpan untuk mengajukan ulang.
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-start gap-2 mb-3">
                        <div class="flex-grow-1">
                            <h4 class="mb-1">{{ $property->name }}</h4>
                            <p class="text-muted mb-0"><i class="ri-map-pin-line align-bottom"></i> {{ $property->lokasi() ?: '-' }}</p>
                        </div>
                        <span class="badge bg-{{ $property->status->badge() }} fs-12">{{ $property->status->label() }}</span>
                    </div>

                    <div class="row text-center border rounded py-2 mb-3 g-0">
                        <div class="col">
                            <p class="text-muted mb-1">Kategori</p>
                            <h6 class="mb-0">{{ $property->kategori->name ?? '-' }}</h6>
                        </div>
                        <div class="col">
                            <p class="text-muted mb-1">Kamar Tidur</p>
                            <h6 class="mb-0">{{ $property->beds }}</h6>
                        </div>
                        <div class="col">
                            <p class="text-muted mb-1">Kamar Mandi</p>
                            <h6 class="mb-0">{{ $property->baths }}</h6>
                        </div>
                        <div class="col">
                            <p class="text-muted mb-1">Luas Tanah</p>
                            <h6 class="mb-0">{{ $property->lt }} m</h6>
                        </div>
                        <div class="col">
                            <p class="text-muted mb-1">Luas Bangunan</p>
                            <h6 class="mb-0">{{ $property->lb }} m</h6>
                        </div>
                    </div>

                    <h5 class="fs-15">Deskripsi</h5>
                    <p class="text-muted">{!! nl2br(e($property->description ?: '-')) !!}</p>

                    <h5 class="fs-15">Alamat</h5>
                    <p class="text-muted">{{ $property->address ?: '-' }}</p>

                    <h5 class="fs-15">Titik Lokasi</h5>
                    @if($property->punyaKoordinat())
                        <div class="mb-3"><x-peta-lokasi :property="$property" tinggi="260px" /></div>
                    @else
                        <p class="text-muted">Belum ditandai di peta. <a href="{{ route('agn.lists.edit', $property) }}">Tandai lokasi</a> agar pencari bisa melihat lokasi dan petunjuk arah.</p>
                    @endif

                    <h5 class="fs-15">Fasilitas</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @forelse($property->fasilitas as $fasilitas)
                            <span class="badge bg-light text-body fs-12"><i class="ri-check-line text-success align-bottom"></i> {{ $fasilitas->name }}</span>
                        @empty
                            <span class="text-muted">-</span>
                        @endforelse
                    </div>
                </div>
            </div>

            @include('agen.partials.gambar-manager', ['editable' => false])
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Harga Sewa</h5>
                </div>
                <div class="card-body">
                    @forelse($property->daftarHarga() as $periode => $harga)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Per {{ $periode }}</span>
                            <strong>{{ $harga }}</strong>
                        </div>
                    @empty
                        <span class="text-muted">-</span>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('agn.lists.edit', $property) }}" class="btn btn-primary"><i class="ri-pencil-line align-bottom"></i> Edit Listing</a>
                    <button type="button" class="btn btn-soft-danger" data-bs-toggle="modal" data-bs-target="#modalHapusListing">
                        <i class="ri-delete-bin-line align-bottom"></i> Hapus Listing
                    </button>
                    <a href="{{ route('agn.lists') }}" class="btn btn-light">Kembali</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Dibuat: {{ $property->created_at?->format('d-m-Y H:i') }}</p>
                    <p class="text-muted mb-0">Disetujui: {{ $property->approved_at?->format('d-m-Y H:i') ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    @include('agen.partials.hapus-listing-modal')
</x-agent.agent-template>
