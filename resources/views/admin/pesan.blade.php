<x-admin.admin-template :title="$judul">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Pesan Kontak</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('adm.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pesan Kontak</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.alert')

    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0">
                <li class="nav-item">
                    <a class="nav-link @unless($belumDibaca) active fw-semibold @endunless" href="{{ route('adm.pesan') }}">Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($belumDibaca) active fw-semibold @endif" href="{{ route('adm.pesan', ['filter' => 'baru']) }}">Belum Dibaca</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>Pengirim</th>
                        <th>Subjek / Pesan</th>
                        <th>Diterima</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($dataPesan as $pesan)
                        <tr class="@if(!$pesan->read_at) table-warning @endif">
                            <td class="text-nowrap">
                                <div class="@if(!$pesan->read_at) fw-semibold @endif">{{ $pesan->name }}</div>
                                <div class="text-muted small">{{ $pesan->email }}</div>
                            </td>
                            <td>
                                @if($pesan->subject)<div class="fw-medium">{{ $pesan->subject }}</div>@endif
                                <div class="text-muted">{{ \Illuminate\Support\Str::limit($pesan->message, 90) }}</div>
                            </td>
                            <td class="text-nowrap">
                                {{ $pesan->created_at?->format('d-m-Y H:i') }}
                                @if(!$pesan->read_at)<span class="badge bg-danger ms-1">Baru</span>@endif
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('adm.pesan.show', $pesan) }}" class="btn btn-sm btn-primary">Baca</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                {{ $belumDibaca ? 'Semua pesan sudah dibaca.' : 'Belum ada pesan.' }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($dataPesan->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $dataPesan->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin.admin-template>
