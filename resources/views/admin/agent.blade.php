<x-admin.admin-template :title="$judul">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Kelola Agen</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('adm.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Agen</li>
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
                    @foreach(\App\Http\Controllers\Admin\Master\AgentController::TAB as $key => $label)
                        <li class="nav-item">
                            <a class="nav-link @if($key === $tab) active fw-semibold @endif" href="{{ route('adm.agent', ['tab' => $key]) }}">
                                {{ $label }}
                                <span class="badge bg-{{ ['aktif' => 'success', 'suspend' => 'danger', 'terhapus' => 'secondary'][$key] }} align-middle ms-1">{{ $jumlahTab[$key] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <form method="GET" action="{{ route('adm.agent') }}" class="d-flex gap-2">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <input type="text" name="q" value="{{ $kata }}" class="form-control form-control-sm" placeholder="Nama, email, atau telepon">
                    <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>Agen</th>
                        <th>Telepon</th>
                        <th>Wilayah</th>
                        <th class="text-center">Listing</th>
                        <th>Bergabung</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($dataAgents as $agent)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $agent->fotoUrl() }}" alt="" class="rounded-circle" style="width:36px;height:36px;object-fit:cover"
                                         onerror="this.onerror=null;this.src='{{ asset(\App\Models\Agent::FOTO_DEFAULT) }}'">
                                    <div>
                                        <a href="{{ route('adm.agent.show', $agent) }}" class="fw-medium">{{ $agent->hasUser->name ?? '(akun tidak ditemukan)' }}</a>
                                        <div class="text-muted small">{{ $agent->hasUser->email ?? '-' }}</div>
                                    </div>
                                </div>
                                @if($agent->isSuspend && $agent->alasan_suspend)
                                    <div class="text-danger small text-wrap mt-1" style="max-width: 300px;">Suspend: {{ \Illuminate\Support\Str::limit($agent->alasan_suspend, 70) }}</div>
                                @endif
                            </td>
                            <td>{{ $agent->phone ?: '-' }}</td>
                            <td class="text-wrap" style="min-width: 150px;">
                                {{ $agent->kecamatan ? $agent->kecamatan->name.', '.($agent->kecamatan->kabupaten->name ?? '') : '-' }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success" title="Tayang">{{ $agent->tayang_count }}</span>
                                <span class="badge bg-warning" title="Menunggu">{{ $agent->pending_count }}</span>
                                <span class="badge bg-danger" title="Ditolak">{{ $agent->ditolak_count }}</span>
                            </td>
                            <td>{{ $agent->created_at?->format('d-m-Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('adm.agent.show', $agent) }}" class="btn btn-sm btn-primary">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                {{ $kata ? 'Tidak ada agen yang cocok dengan "'.$kata.'".' : 'Tidak ada agen di tab ini.' }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <p class="text-muted small mt-2 mb-0">
                Kolom listing: <span class="badge bg-success">tayang</span> <span class="badge bg-warning">menunggu</span> <span class="badge bg-danger">ditolak</span>
            </p>

            @if($dataAgents->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $dataAgents->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin.admin-template>
