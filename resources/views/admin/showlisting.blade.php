<x-admin.admin-template :title="$judul">
    @php
        $agen = $property->agent;
        $defaultGambar = \App\Models\Gambar::defaultUrl();
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tinjau Listing</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('adm.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('adm.listing', ['status' => $property->status->value]) }}">Moderasi Listing</a></li>
                        <li class="breadcrumb-item active">Tinjau</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.alert')

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-start gap-2 mb-3">
                        <div class="flex-grow-1">
                            <h4 class="mb-1">{{ $property->name }}</h4>
                            <p class="text-muted mb-0"><i class="ri-map-pin-line align-bottom"></i> {{ $property->lokasi() ?: '-' }}</p>
                        </div>
                        <span class="badge bg-{{ $property->status->badge() }} fs-12">{{ $property->status->label() }}</span>
                    </div>

                    @if($property->status === \App\Enums\PropertyStatus::Rejected && $property->alasan_penolakan)
                        <div class="alert alert-danger">
                            <strong>Alasan penolakan sebelumnya:</strong> {{ $property->alasan_penolakan }}
                        </div>
                    @endif

                    <div class="row g-2 mb-3">
                        @forelse($property->gambars as $gambar)
                            <div class="col-6 col-md-4">
                                <a href="{{ $gambar->url }}" target="_blank" rel="noopener">
                                    <img src="{{ $gambar->url }}" alt="Foto {{ $loop->iteration }}" class="img-fluid rounded w-100"
                                         style="height: 160px; object-fit: cover;"
                                         onerror="this.onerror=null;this.src='{{ $defaultGambar }}';this.closest('a').href=this.src">
                                </a>
                                @if($gambar->isDefault)<span class="badge bg-primary mt-1">Foto Utama</span>@endif
                            </div>
                        @empty
                            <div class="col-12"><div class="alert alert-warning mb-0">Listing ini tidak memiliki foto.</div></div>
                        @endforelse
                    </div>

                    <div class="row text-center border rounded py-2 mb-3 g-0">
                        <div class="col"><p class="text-muted mb-1">Kategori</p><h6 class="mb-0">{{ $property->kategori->name ?? '-' }}</h6></div>
                        <div class="col"><p class="text-muted mb-1">Kamar Tidur</p><h6 class="mb-0">{{ $property->beds }}</h6></div>
                        <div class="col"><p class="text-muted mb-1">Kamar Mandi</p><h6 class="mb-0">{{ $property->baths }}</h6></div>
                        <div class="col"><p class="text-muted mb-1">Luas Tanah</p><h6 class="mb-0">{{ $property->lt }} m</h6></div>
                        <div class="col"><p class="text-muted mb-1">Luas Bangunan</p><h6 class="mb-0">{{ $property->lb }} m</h6></div>
                    </div>

                    <h5 class="fs-15">Harga Sewa</h5>
                    <ul class="list-unstyled">
                        @forelse($property->daftarHarga() as $periode => $harga)
                            <li>Per {{ $periode }}: <strong>{{ $harga }}</strong></li>
                        @empty
                            <li class="text-danger">Belum ada harga.</li>
                        @endforelse
                    </ul>

                    <h5 class="fs-15">Deskripsi</h5>
                    <p class="text-muted">{!! nl2br(e($property->description ?: '-')) !!}</p>

                    <h5 class="fs-15">Alamat</h5>
                    <p class="text-muted">{{ $property->address ?: '-' }}</p>

                    <h5 class="fs-15">Titik Lokasi</h5>
                    @if($property->punyaKoordinat())
                        <div class="mb-3"><x-peta-lokasi :property="$property" tinggi="260px" /></div>
                    @else
                        <p class="text-muted">Agen belum menandai lokasi di peta.</p>
                    @endif

                    <h5 class="fs-15">Fasilitas</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @forelse($property->fasilitas as $fasilitas)
                            <span class="badge bg-light text-body fs-12">{{ $fasilitas->name }}</span>
                        @empty
                            <span class="text-muted">-</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Keputusan</h5></div>
                <div class="card-body">
                    @if($property->status !== \App\Enums\PropertyStatus::Approved)
                        <form method="POST" action="{{ route('adm.listing.approve', $property) }}" class="mb-3">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success w-100">
                                <i class="ri-check-line align-bottom"></i> Setujui &amp; Tayangkan
                            </button>
                        </form>
                    @else
                        <div class="alert alert-success">
                            Listing sedang tayang sejak {{ $property->approved_at?->format('d-m-Y H:i') }}.
                            <a href="{{ route('front.properties.detail', $property->slug) }}" target="_blank" rel="noopener">Lihat di website</a>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('adm.listing.reject', $property) }}">
                        @csrf
                        @method('PATCH')
                        <label for="alasan_penolakan" class="form-label">
                            {{ $property->status === \App\Enums\PropertyStatus::Approved ? 'Turunkan listing' : 'Tolak listing' }} — alasan <span class="text-danger">*</span>
                        </label>
                        <textarea name="alasan_penolakan" id="alasan_penolakan" rows="4" maxlength="1000"
                                  class="form-control @error('alasan_penolakan') is-invalid @enderror"
                                  placeholder="Contoh: Foto kurang jelas, mohon unggah foto ruangan yang lebih terang.">{{ old('alasan_penolakan') }}</textarea>
                        @error('alasan_penolakan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-soft-danger w-100 mt-2">
                            <i class="ri-close-line align-bottom"></i>
                            {{ $property->status === \App\Enums\PropertyStatus::Approved ? 'Turunkan dari Website' : 'Tolak Listing' }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Agen</h5></div>
                <div class="card-body">
                    <p class="mb-1 fw-medium">{{ $agen?->hasUser?->name ?? '-' }}</p>
                    <p class="mb-1 text-muted">{{ $agen?->hasUser?->email }}</p>
                    <p class="mb-1 text-muted">{{ $agen?->phone ?: 'Tanpa nomor telepon' }}</p>
                    @if($agen?->isSuspend)
                        <span class="badge bg-danger">Agen disuspend</span>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-1">Dibuat: {{ $property->created_at?->format('d-m-Y H:i') }}</p>
                    <p class="text-muted mb-0">Diperbarui: {{ $property->updated_at?->format('d-m-Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-admin.admin-template>
