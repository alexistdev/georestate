{{-- Halaman kelola master data berbasis nama (kategori & fasilitas). Variabel $info dari MasterNamaController. --}}
<x-admin.admin-template :title="$judul">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Kelola {{ $info['judul'] }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('adm.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $info['judul'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.alert')

    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Tambah {{ $info['label'] }}</h5></div>
                <div class="card-body">
                    <form method="POST" action="{{ route($info['route'].'.save') }}">
                        @csrf
                        <label for="namaBaru" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="namaBaru" maxlength="100" required
                               value="{{ old('_form') === 'tambah' ? old('name') : '' }}"
                               class="form-control" placeholder="{{ $info['contoh'] }}">
                        <input type="hidden" name="_form" value="tambah">
                        <button type="submit" class="btn btn-primary w-100 mt-3"><i class="ri-add-line align-bottom"></i> Tambah</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-0 small">
                        {{ $info['label'] }} yang dihapus tidak bisa dipilih lagi di form listing agen maupun filter pencarian,
                        tapi listing lama tetap menampilkannya. Data yang dihapus bisa dipulihkan dari tab Terhapus.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0 flex-grow-1">
                            <li class="nav-item">
                                <a class="nav-link @unless($terhapus) active fw-semibold @endunless" href="{{ route($info['route']) }}">
                                    Aktif <span class="badge bg-success align-middle ms-1">{{ $jumlahAktif }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($terhapus) active fw-semibold @endif" href="{{ route($info['route'], ['tab' => 'terhapus']) }}">
                                    Terhapus <span class="badge bg-secondary align-middle ms-1">{{ $jumlahTerhapus }}</span>
                                </a>
                            </li>
                        </ul>
                        <form method="GET" action="{{ route($info['route']) }}" class="d-flex gap-2">
                            @if($terhapus)<input type="hidden" name="tab" value="terhapus">@endif
                            <input type="text" name="q" value="{{ $kata }}" class="form-control form-control-sm" placeholder="Cari nama">
                            <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th class="text-center">Dipakai Listing</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($dataMaster as $item)
                                <tr>
                                    <td class="fw-medium">{{ $item->name }}</td>
                                    <td class="text-center">{{ $item->properties_count }}</td>
                                    <td class="text-end text-nowrap">
                                        @if($terhapus)
                                            <form method="POST" action="{{ route($info['route'].'.restore', $item->id) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-soft-success">Pulihkan</button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-sm btn-soft-primary btn-ubah"
                                                    data-bs-toggle="modal" data-bs-target="#modalUbah"
                                                    data-action="{{ route($info['route'].'.update', $item->id) }}"
                                                    data-name="{{ $item->name }}">
                                                <i class="ri-pencil-line align-bottom"></i> Ubah
                                            </button>
                                            <form method="POST" action="{{ route($info['route'].'.delete', $item->id) }}" class="d-inline"
                                                  onsubmit="return confirm('Hapus data ini? Listing lama tetap menampilkannya, tapi tidak bisa dipilih lagi.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-soft-danger"><i class="ri-delete-bin-line align-bottom"></i> Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        {{ $kata ? 'Tidak ada data yang cocok dengan "'.$kata.'".' : 'Belum ada data di tab ini.' }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($dataMaster->hasPages())
                        <div class="d-flex justify-content-end mt-3">
                            {{ $dataMaster->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUbah" tabindex="-1" aria-labelledby="judulModalUbah" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="formUbah" action="{{ old('_form') === 'ubah' ? old('_action') : '' }}">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="judulModalUbah">Ubah {{ $info['label'] }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <label for="namaUbah" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="namaUbah" maxlength="100" required class="form-control"
                               value="{{ old('_form') === 'ubah' ? old('name') : '' }}">
                        <input type="hidden" name="_form" value="ubah">
                        <input type="hidden" name="_action" id="actionUbah" value="{{ old('_action') }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('customJS')
        <script>
            document.addEventListener('click', function (e) {
                const tombol = e.target.closest('.btn-ubah');
                if (!tombol) {
                    return;
                }
                document.getElementById('formUbah').action = tombol.dataset.action;
                document.getElementById('actionUbah').value = tombol.dataset.action;
                document.getElementById('namaUbah').value = tombol.dataset.name;
            });

            // Jika validasi ubah gagal, buka kembali modal dengan isian terakhir.
            @if(old('_form') === 'ubah' && $errors->any())
                document.addEventListener('DOMContentLoaded', function () {
                    new bootstrap.Modal(document.getElementById('modalUbah')).show();
                });
            @endif
        </script>
    @endpush
</x-admin.admin-template>
