<x-admin.admin-template :title="$judul">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Kelola Pencari Properti</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('adm.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pencari Properti</li>
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
                    <li class="nav-item">
                        <a class="nav-link @unless($terhapus) active fw-semibold @endunless" href="{{ route('adm.user') }}">
                            Aktif <span class="badge bg-success align-middle ms-1">{{ $jumlahAktif }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($terhapus) active fw-semibold @endif" href="{{ route('adm.user', ['tab' => 'terhapus']) }}">
                            Terhapus <span class="badge bg-secondary align-middle ms-1">{{ $jumlahTerhapus }}</span>
                        </a>
                    </li>
                </ul>
                <form method="GET" action="{{ route('adm.user') }}" class="d-flex gap-2">
                    @if($terhapus)<input type="hidden" name="tab" value="terhapus">@endif
                    <input type="text" name="q" value="{{ $kata }}" class="form-control form-control-sm" placeholder="Nama atau email">
                    <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Terdaftar</th>
                        @if($terhapus)<th>Dihapus</th>@endif
                        <th class="text-end">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($dataUsers as $user)
                        <tr>
                            <td class="fw-medium">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at?->format('d-m-Y') }}</td>
                            @if($terhapus)<td>{{ $user->deleted_at?->format('d-m-Y H:i') }}</td>@endif
                            <td class="text-end">
                                @if($terhapus)
                                    <form method="POST" action="{{ route('adm.user.restore', $user) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-soft-success">Pulihkan</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('adm.user.delete', $user) }}" class="d-inline"
                                          onsubmit="return confirm('Hapus akun ini? Akun tidak bisa login, tapi masih bisa dipulihkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $terhapus ? 5 : 4 }}" class="text-center text-muted py-4">
                                {{ $kata ? 'Tidak ada pengguna yang cocok dengan "'.$kata.'".' : 'Tidak ada pengguna di tab ini.' }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($dataUsers->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $dataUsers->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin.admin-template>
