<x-agent.agent-template :title="$title" :menu-utama="$menuUtama" :menu-kedua="$menuKedua">
    @php
        $listing = $inquiry->property;
        $pesanBalasan = 'Halo '.$inquiry->name.', terima kasih sudah bertanya tentang "'.($listing->name ?? 'properti kami').'" di '.config('georestate.nama').'. ';
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Detail Pertanyaan</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('agn.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('agn.pertanyaan') }}">Pertanyaan</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <h5 class="card-title mb-0 flex-grow-1">Pesan dari {{ $inquiry->name }}</h5>
                    <span class="badge bg-{{ $inquiry->status->badge() }}">{{ $inquiry->status->label() }}</span>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Diterima {{ $inquiry->created_at?->format('d-m-Y H:i') }}</p>
                    <p class="mb-0" style="white-space: pre-line;">{{ $inquiry->message }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Properti yang Ditanyakan</h5></div>
                <div class="card-body d-flex align-items-center gap-3">
                    <img src="{{ $listing?->gambarUtamaUrl() ?? \App\Models\Gambar::defaultUrl() }}" alt="" class="rounded" style="width:96px;height:72px;object-fit:cover"
                         onerror="this.onerror=null;this.src='{{ \App\Models\Gambar::defaultUrl() }}'">
                    <div class="flex-grow-1">
                        <div class="fw-medium">{{ $listing->name ?? '-' }}</div>
                        <div class="text-muted small">{{ $listing?->lokasi() }}</div>
                    </div>
                    @if($listing && !$listing->trashed())
                        <a href="{{ route('agn.lists.show', $listing) }}" class="btn btn-sm btn-soft-primary">Lihat Listing</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Penanya</h5></div>
                <div class="card-body">
                    <p class="fw-medium mb-1">{{ $inquiry->name }}</p>
                    <p class="mb-1"><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></p>
                    <p class="mb-3">{{ $inquiry->phone ?: 'Tanpa nomor telepon' }}</p>
                    <div class="d-grid gap-2">
                        @if($inquiry->whatsappUrl())
                            <a href="{{ $inquiry->whatsappUrl($pesanBalasan) }}" target="_blank" rel="noopener" class="btn btn-success">
                                <i class="ri-whatsapp-line align-bottom"></i> Balas via WhatsApp
                            </a>
                        @endif
                        <a href="mailto:{{ $inquiry->email }}?subject={{ rawurlencode('Re: '.($listing->name ?? 'Pertanyaan Anda')) }}&body={{ rawurlencode($pesanBalasan) }}"
                           class="btn btn-soft-primary">
                            <i class="ri-mail-send-line align-bottom"></i> Balas via Email
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Status</h5></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('agn.pertanyaan.status', $inquiry) }}">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select mb-2" aria-label="Status pertanyaan">
                            @foreach(\App\Enums\InquiryStatus::cases() as $pilihan)
                                <option value="{{ $pilihan->value }}" @selected($pilihan === $inquiry->status)>{{ $pilihan->label() }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary w-100">Simpan Status</button>
                    </form>
                    <p class="text-muted small mt-2 mb-0">Status ini juga terlihat oleh penanya di halaman riwayat pertanyaannya.</p>
                </div>
            </div>
        </div>
    </div>
</x-agent.agent-template>
