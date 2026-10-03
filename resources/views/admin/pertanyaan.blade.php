<x-admin.admin-template :title="$judul">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Pertanyaan ke Agen</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('adm.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pertanyaan ke Agen</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.alert')

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center gap-2">
            <p class="text-muted mb-0 flex-grow-1">Semua pertanyaan calon penyewa ke agen. Admin hanya memantau dan menghapus spam; balasan dilakukan oleh agen.</p>
            <form method="GET" action="{{ route('adm.pertanyaan') }}" class="d-flex gap-2">
                <input type="text" name="q" value="{{ $kata }}" class="form-control form-control-sm" placeholder="Nama, email, atau isi pesan">
                <button type="submit" class="btn btn-sm btn-primary">Cari</button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>Penanya</th>
                        <th>Properti &amp; Pesan</th>
                        <th>Agen</th>
                        <th class="text-center">Status</th>
                        <th>Diterima</th>
                        <th class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($dataPertanyaan as $tanya)
                        <tr>
                            <td class="text-nowrap">
                                <div class="fw-medium">{{ $tanya->name }}</div>
                                <div class="text-muted small">{{ $tanya->email }}</div>
                            </td>
                            <td>
                                <div class="fw-medium">{{ \Illuminate\Support\Str::limit($tanya->property->name ?? '-', 40) }}</div>
                                <div class="text-muted">{{ \Illuminate\Support\Str::limit($tanya->message, 120) }}</div>
                            </td>
                            <td>{{ $tanya->agent?->hasUser?->name ?? '-' }}</td>
                            <td class="text-center"><span class="badge bg-{{ $tanya->status->badge() }}">{{ $tanya->status->label() }}</span></td>
                            <td class="text-nowrap">{{ $tanya->created_at?->format('d-m-Y H:i') }}</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('adm.pertanyaan.delete', $tanya) }}" class="d-inline"
                                      onsubmit="return confirm('Hapus pertanyaan ini (misalnya karena spam)?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-soft-danger"><i class="ri-delete-bin-line align-bottom"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                {{ $kata ? 'Tidak ada pertanyaan yang cocok dengan "'.$kata.'".' : 'Belum ada pertanyaan.' }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($dataPertanyaan->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $dataPertanyaan->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin.admin-template>
