<x-agent.agent-template :title="$title" :menu-utama="$menuUtama" :menu-kedua="$menuKedua">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Pertanyaan Calon Penyewa</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('agn.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Pertanyaan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0">
                <li class="nav-item">
                    <a class="nav-link @if($status === null) active fw-semibold @endif" href="{{ route('agn.pertanyaan') }}">
                        Semua <span class="badge bg-secondary align-middle ms-1">{{ $jumlah->sum() }}</span>
                    </a>
                </li>
                @foreach(\App\Enums\InquiryStatus::cases() as $tab)
                    <li class="nav-item">
                        <a class="nav-link @if($tab === $status) active fw-semibold @endif" href="{{ route('agn.pertanyaan', ['status' => $tab->value]) }}">
                            {{ $tab->label() }} <span class="badge bg-{{ $tab->badge() }} align-middle ms-1">{{ $jumlah[$tab->value] ?? 0 }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>Penanya</th>
                        <th>Properti &amp; Pesan</th>
                        <th>Diterima</th>
                        <th class="text-center">Status</th>
                        <th class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($dataPertanyaan as $tanya)
                        <tr class="@if(!$tanya->read_at) table-warning @endif">
                            <td class="text-nowrap">
                                <div class="@if(!$tanya->read_at) fw-semibold @endif">{{ $tanya->name }}</div>
                                <div class="text-muted small">{{ $tanya->phone ?: $tanya->email }}</div>
                            </td>
                            <td>
                                <div class="fw-medium">{{ \Illuminate\Support\Str::limit($tanya->property->name ?? '-', 45) }}</div>
                                <div class="text-muted">{{ \Illuminate\Support\Str::limit($tanya->message, 80) }}</div>
                            </td>
                            <td class="text-nowrap">
                                {{ $tanya->created_at?->format('d-m-Y H:i') }}
                                <div class="text-muted small">{{ $tanya->created_at?->diffForHumans() }}</div>
                            </td>
                            <td class="text-center"><span class="badge bg-{{ $tanya->status->badge() }}">{{ $tanya->status->label() }}</span></td>
                            <td class="text-end"><a href="{{ route('agn.pertanyaan.show', $tanya) }}" class="btn btn-sm btn-primary">Buka</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada pertanyaan{{ $status ? ' dengan status '.strtolower($status->label()) : '' }}.
                                Pertanyaan dari form "Tanya Agen" di halaman listing Anda akan masuk ke sini.
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
</x-agent.agent-template>
