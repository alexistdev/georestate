<x-agent.agent-template :title="$title" :menu-utama="$menuUtama" :menu-kedua="$menuKedua">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1">Halo, {{ auth()->user()->name }}</h4>
                    <p class="text-muted mb-0">Ringkasan listing Anda.</p>
                </div>
                <a href="{{ route('agn.lists.add') }}" class="btn btn-info"><i class="ri-add-fill me-1 align-bottom"></i> Tambah Listing</a>
            </div>
        </div>
    </div>

    @if($pertanyaanBaru > 0)
        <div class="alert alert-info d-flex flex-wrap align-items-center gap-2">
            <div class="flex-grow-1"><strong>{{ $pertanyaanBaru }} pertanyaan baru</strong> dari calon penyewa menunggu balasan Anda.</div>
            <a href="{{ route('agn.pertanyaan', ['status' => 'baru']) }}" class="btn btn-sm btn-info">Lihat Pertanyaan</a>
        </div>
    @endif

    {{-- Notifikasi hasil moderasi admin --}}
    @foreach($ditolak as $listing)
        <div class="alert alert-danger d-flex flex-wrap align-items-center gap-2">
            <div class="flex-grow-1">
                <strong>Listing "{{ $listing->name }}" ditolak admin.</strong>
                @if($listing->alasan_penolakan)
                    <div>Alasan: {{ $listing->alasan_penolakan }}</div>
                @endif
            </div>
            <a href="{{ route('agn.lists.edit', $listing) }}" class="btn btn-sm btn-danger">Perbaiki</a>
        </div>
    @endforeach
    @foreach($baruDisetujui as $listing)
        <div class="alert alert-success d-flex flex-wrap align-items-center gap-2">
            <div class="flex-grow-1">
                <strong>Listing "{{ $listing->name }}" disetujui</strong>
                dan tayang sejak {{ $listing->approved_at?->format('d-m-Y H:i') }}.
            </div>
            <a href="{{ route('front.properties.detail', $listing->slug) }}" target="_blank" rel="noopener" class="btn btn-sm btn-success">Lihat di Website</a>
        </div>
    @endforeach

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <x-stat-card label="Tayang di Website" :nilai="$jumlahTayang" ikon="ri-checkbox-circle-line" warna="success" :link="route('agn.lists')" />
        </div>
        <div class="col-md-4">
            <x-stat-card label="Menunggu Persetujuan" :nilai="$jumlahPending" ikon="ri-time-line" warna="warning" :link="route('agn.lists')" />
        </div>
        <div class="col-md-4">
            <x-stat-card label="Ditolak" :nilai="$jumlahDitolak" ikon="ri-close-circle-line" warna="danger" :link="route('agn.lists')" />
        </div>
    </div>

    <div class="card">
        <div class="card-body d-flex flex-wrap align-items-center gap-2">
            <p class="text-muted mb-0 flex-grow-1">
                Listing baru dan listing yang diedit akan ditinjau admin sebelum tampil di website.
                Notifikasi persetujuan ditampilkan selama {{ $hariNotifikasi }} hari.
            </p>
            <a href="{{ route('agn.lists') }}" class="btn btn-soft-primary">Kelola Listing</a>
        </div>
    </div>
</x-agent.agent-template>
