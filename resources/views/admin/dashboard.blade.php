<x-admin.admin-template :title="$judul">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1">Selamat datang, {{ auth()->user()->name }}</h4>
                    <p class="text-muted mb-0">Ringkasan aktivitas {{ config('georestate.nama') }}.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xxl col-lg-4 col-sm-6">
            <x-stat-card label="Listing Tayang" :nilai="$listingTayang" ikon="ri-home-4-line" warna="success"
                         :link="route('adm.listing', ['status' => 'approved'])" />
        </div>
        <div class="col-xxl col-lg-4 col-sm-6">
            <x-stat-card label="Menunggu Persetujuan" :nilai="$listingPending" ikon="ri-time-line" warna="warning"
                         :link="route('adm.listing', ['status' => 'pending'])" />
        </div>
        <div class="col-xxl col-lg-4 col-sm-6">
            <x-stat-card label="Listing Ditolak" :nilai="$listingDitolak" ikon="ri-close-circle-line" warna="danger"
                         :link="route('adm.listing', ['status' => 'rejected'])" />
        </div>
        <div class="col-xxl col-lg-4 col-sm-6">
            <x-stat-card label="Agen Aktif" :nilai="$agenAktif" ikon="ri-user-star-line" warna="primary"
                         :link="route('adm.agent')" :catatan="$agenSuspend ? $agenSuspend.' agen disuspend' : null" />
        </div>
        <div class="col-xxl col-lg-4 col-sm-6">
            <x-stat-card label="Pencari Properti" :nilai="$jumlahUser" ikon="ri-group-line" warna="info" :link="route('adm.user')" />
        </div>
        <div class="col-xxl col-lg-4 col-sm-6">
            <x-stat-card label="Pesan Belum Dibaca" :nilai="$pesanBaru" ikon="ri-mail-unread-line" warna="secondary"
                         :link="route('adm.pesan', ['filter' => 'baru'])" />
        </div>
        @isset($jumlahAdmin)
            <div class="col-xxl col-lg-4 col-sm-6">
                <x-stat-card label="Akun Admin" :nilai="$jumlahAdmin" ikon="ri-shield-user-line" warna="primary"
                             :link="route('sup.admin')" />
            </div>
        @endisset
    </div>

    <div class="row">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Antrean Moderasi</h5>
                    <a href="{{ route('adm.listing') }}" class="btn btn-sm btn-soft-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-nowrap align-middle mb-0">
                            <thead class="table-light text-muted">
                            <tr>
                                <th>Listing</th>
                                <th>Agen</th>
                                <th>Menunggu Sejak</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($antrean as $listing)
                                <tr>
                                    <td>
                                        <div class="fw-medium">{{ \Illuminate\Support\Str::limit($listing->name, 40) }}</div>
                                        <small class="text-muted">{{ $listing->kategori->name ?? '-' }}</small>
                                    </td>
                                    <td>{{ $listing->agent?->hasUser?->name ?? '-' }}</td>
                                    <td>{{ $listing->updated_at?->diffForHumans() }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('adm.listing.show', $listing) }}" class="btn btn-sm btn-primary">Tinjau</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Tidak ada listing yang menunggu persetujuan.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Pesan Kontak Terbaru</h5>
                    <a href="{{ route('adm.pesan') }}" class="btn btn-sm btn-soft-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($pesanTerbaru as $pesan)
                            <li class="list-group-item px-0">
                                <a href="{{ route('adm.pesan.show', $pesan) }}" class="d-flex text-body">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="@if(!$pesan->read_at) fw-semibold @endif">
                                            {{ $pesan->name }}
                                            @if(!$pesan->read_at)<span class="badge bg-danger ms-1">Baru</span>@endif
                                        </div>
                                        <div class="text-muted text-truncate">{{ $pesan->subject ?: \Illuminate\Support\Str::limit($pesan->message, 60) }}</div>
                                    </div>
                                    <small class="text-muted ms-2 flex-shrink-0">{{ $pesan->created_at?->diffForHumans() }}</small>
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-center text-muted py-4">Belum ada pesan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-admin.admin-template>
