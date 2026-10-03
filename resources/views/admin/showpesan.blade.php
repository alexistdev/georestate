<x-admin.admin-template :title="$judul">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Pesan Kontak</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('adm.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('adm.pesan') }}">Pesan Kontak</a></li>
                        <li class="breadcrumb-item active">Baca</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-1">{{ $pesan->subject ?: '(Tanpa subjek)' }}</h5>
                    <p class="text-muted mb-0">Diterima {{ $pesan->created_at?->format('d-m-Y H:i') }}</p>
                </div>
                <div class="card-body">
                    <p class="mb-0" style="white-space: pre-line;">{{ $pesan->message }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Pengirim</h5></div>
                <div class="card-body">
                    <p class="fw-medium mb-1">{{ $pesan->name }}</p>
                    <p class="mb-1"><a href="mailto:{{ $pesan->email }}">{{ $pesan->email }}</a></p>
                    @if($pesan->phone)
                        <p class="mb-0">{{ $pesan->phone }}</p>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body d-grid gap-2">
                    <a href="mailto:{{ $pesan->email }}?subject={{ rawurlencode('Re: '.($pesan->subject ?: 'Pesan Anda')) }}" class="btn btn-primary">
                        <i class="ri-mail-send-line align-bottom"></i> Balas via Email
                    </a>
                    <form method="POST" action="{{ route('adm.pesan.delete', $pesan) }}" onsubmit="return confirm('Hapus pesan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-soft-danger w-100"><i class="ri-delete-bin-line align-bottom"></i> Hapus</button>
                    </form>
                    <a href="{{ route('adm.pesan') }}" class="btn btn-light">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-admin.admin-template>
