<x-admin.admin-template :title="$judul">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Moderasi Listing</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('adm.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Moderasi Listing</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.alert')

    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0 flex-grow-1">
                    @foreach(\App\Enums\PropertyStatus::cases() as $tab)
                        <li class="nav-item">
                            <a class="nav-link @if($tab === $status) active fw-semibold @endif"
                               href="{{ route('adm.listing', ['status' => $tab->value]) }}">
                                {{ $tab->label() }}
                                <span class="badge bg-{{ $tab->badge() }} align-middle ms-1">{{ $jumlah[$tab->value] ?? 0 }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <form method="GET" action="{{ route('adm.listing') }}" class="d-flex gap-2">
                    <input type="hidden" name="status" value="{{ $status->value }}">
                    <input type="text" name="q" value="{{ $kata }}" class="form-control form-control-sm" placeholder="Cari nama listing">
                    <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light">
                    <tr>
                        <th style="width: 80px;">Foto</th>
                        <th>Listing</th>
                        <th>Agen</th>
                        <th>Lokasi</th>
                        <th>{{ $status === \App\Enums\PropertyStatus::Pending ? 'Menunggu Sejak' : 'Diperbarui' }}</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($dataListing as $listing)
                        <tr>
                            <td>
                                <img src="{{ $listing->gambarUtamaUrl() }}" alt="" class="rounded" style="width:64px;height:48px;object-fit:cover"
                                     onerror="this.onerror=null;this.src='{{ \App\Models\Gambar::defaultUrl() }}'">
                            </td>
                            <td>
                                <a href="{{ route('adm.listing.show', $listing) }}" class="fw-medium">{{ \Illuminate\Support\Str::limit($listing->name, 50) }}</a>
                                <div class="text-muted small">{{ $listing->kategori->name ?? '-' }}</div>
                                @if($listing->status === \App\Enums\PropertyStatus::Rejected && $listing->alasan_penolakan)
                                    <div class="text-danger small text-wrap" style="max-width: 320px;">Alasan: {{ \Illuminate\Support\Str::limit($listing->alasan_penolakan, 80) }}</div>
                                @endif
                            </td>
                            <td>{{ $listing->agent?->hasUser?->name ?? '-' }}</td>
                            <td class="text-wrap" style="min-width: 160px;">{{ $listing->lokasi() ?: '-' }}</td>
                            <td>
                                {{ $listing->updated_at?->format('d-m-Y H:i') }}
                                <div class="text-muted small">{{ $listing->updated_at?->diffForHumans() }}</div>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('adm.listing.show', $listing) }}" class="btn btn-sm btn-primary">
                                    {{ $status === \App\Enums\PropertyStatus::Pending ? 'Tinjau' : 'Detail' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                @if($kata)
                                    Tidak ada listing yang cocok dengan "{{ $kata }}".
                                @else
                                    Tidak ada listing dengan status {{ strtolower($status->label()) }}.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($dataListing->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $dataListing->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin.admin-template>
