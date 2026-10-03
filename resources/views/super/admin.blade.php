<x-admin.admin-template :title="$judul">
    @php($formGagal = $errors->any() ? old('_form') : null)
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Kelola Admin</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('sup.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Kelola Admin</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.alert')

    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Tambah Admin</h5></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('sup.admin.save') }}" autocomplete="off">
                        @csrf
                        <input type="hidden" name="_form" value="tambah">
                        <div class="mb-3">
                            <label for="tambahNama" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="tambahNama" maxlength="100" required class="form-control"
                                   value="{{ $formGagal === 'tambah' ? old('name') : '' }}">
                        </div>
                        <div class="mb-3">
                            <label for="tambahEmail" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="tambahEmail" maxlength="255" required class="form-control"
                                   value="{{ $formGagal === 'tambah' ? old('email') : '' }}">
                        </div>
                        <div class="mb-3">
                            <label for="tambahPassword" class="form-label">Password Awal <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="tambahPassword" required autocomplete="new-password" class="form-control">
                            <div class="form-text">Minimal 8 karakter. Sampaikan ke admin dan minta ia menggantinya.</div>
                        </div>
                        <div class="mb-3">
                            <label for="tambahPassword2" class="form-label">Ulangi Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" id="tambahPassword2" required autocomplete="new-password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="ri-user-add-line align-bottom"></i> Tambah Admin</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="text-muted small mb-0">
                        Halaman ini hanya bisa membuat akun <strong>Admin</strong>. Admin bisa memoderasi listing serta mengelola agen,
                        pencari properti, dan master data, tetapi tidak bisa mengelola akun admin lain.
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
                                <a class="nav-link @unless($terhapus) active fw-semibold @endunless" href="{{ route('sup.admin') }}">
                                    Aktif <span class="badge bg-success align-middle ms-1">{{ $jumlahAktif }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($terhapus) active fw-semibold @endif" href="{{ route('sup.admin', ['tab' => 'terhapus']) }}">
                                    Terhapus <span class="badge bg-secondary align-middle ms-1">{{ $jumlahTerhapus }}</span>
                                </a>
                            </li>
                        </ul>
                        <form method="GET" action="{{ route('sup.admin') }}" class="d-flex gap-2">
                            @if($terhapus)<input type="hidden" name="tab" value="terhapus">@endif
                            <input type="text" name="q" value="{{ $kata }}" class="form-control form-control-sm" placeholder="Nama atau email">
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
                                <th>Email</th>
                                <th>{{ $terhapus ? 'Dihapus' : 'Dibuat' }}</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($dataAdmin as $admin)
                                <tr>
                                    <td class="fw-medium">{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ ($terhapus ? $admin->deleted_at : $admin->created_at)?->format('d-m-Y') }}</td>
                                    <td class="text-end text-nowrap">
                                        @if($terhapus)
                                            <form method="POST" action="{{ route('sup.admin.restore', $admin) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-soft-success">Pulihkan</button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-sm btn-soft-primary btn-ubah-admin"
                                                    data-bs-toggle="modal" data-bs-target="#modalUbahAdmin"
                                                    data-action="{{ route('sup.admin.update', $admin) }}"
                                                    data-name="{{ $admin->name }}" data-email="{{ $admin->email }}">
                                                <i class="ri-pencil-line align-bottom"></i> Ubah
                                            </button>
                                            <button type="button" class="btn btn-sm btn-soft-info btn-reset-admin"
                                                    data-bs-toggle="modal" data-bs-target="#modalResetAdmin"
                                                    data-action="{{ route('sup.admin.password', $admin) }}"
                                                    data-email="{{ $admin->email }}">
                                                <i class="ri-lock-password-line align-bottom"></i> Reset Password
                                            </button>
                                            <form method="POST" action="{{ route('sup.admin.delete', $admin) }}" class="d-inline"
                                                  onsubmit="return confirm('Hapus akun admin ini? Akun tidak bisa login, tapi masih bisa dipulihkan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-soft-danger"><i class="ri-delete-bin-line align-bottom"></i> Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        {{ $kata ? 'Tidak ada admin yang cocok dengan "'.$kata.'".' : 'Belum ada akun admin di tab ini.' }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($dataAdmin->hasPages())
                        <div class="d-flex justify-content-end mt-3">
                            {{ $dataAdmin->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUbahAdmin" tabindex="-1" aria-labelledby="judulUbahAdmin" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="formUbahAdmin" action="{{ $formGagal === 'ubah' ? old('_action') : '' }}" autocomplete="off">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="_form" value="ubah">
                    <input type="hidden" name="_action" id="actionUbahAdmin" value="{{ $formGagal === 'ubah' ? old('_action') : '' }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="judulUbahAdmin">Ubah Data Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ubahNama" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="ubahNama" maxlength="100" required class="form-control"
                                   value="{{ $formGagal === 'ubah' ? old('name') : '' }}">
                        </div>
                        <div>
                            <label for="ubahEmail" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="ubahEmail" maxlength="255" required class="form-control"
                                   value="{{ $formGagal === 'ubah' ? old('email') : '' }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalResetAdmin" tabindex="-1" aria-labelledby="judulResetAdmin" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="formResetAdmin" action="{{ $formGagal === 'reset' ? old('_action') : '' }}" autocomplete="off">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="_form" value="reset">
                    <input type="hidden" name="_action" id="actionResetAdmin" value="{{ $formGagal === 'reset' ? old('_action') : '' }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="judulResetAdmin">Reset Password <span id="emailResetAdmin" class="text-muted fs-14"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="resetPassword" class="form-label">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="resetPassword" required autocomplete="new-password" class="form-control">
                            <div class="form-text">Minimal 8 karakter.</div>
                        </div>
                        <div>
                            <label for="resetPassword2" class="form-label">Ulangi Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" id="resetPassword2" required autocomplete="new-password" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('customJS')
        <script>
            document.addEventListener('click', function (e) {
                const ubah = e.target.closest('.btn-ubah-admin');
                if (ubah) {
                    document.getElementById('formUbahAdmin').action = ubah.dataset.action;
                    document.getElementById('actionUbahAdmin').value = ubah.dataset.action;
                    document.getElementById('ubahNama').value = ubah.dataset.name;
                    document.getElementById('ubahEmail').value = ubah.dataset.email;
                }
                const reset = e.target.closest('.btn-reset-admin');
                if (reset) {
                    document.getElementById('formResetAdmin').action = reset.dataset.action;
                    document.getElementById('actionResetAdmin').value = reset.dataset.action;
                    document.getElementById('emailResetAdmin').textContent = '(' + reset.dataset.email + ')';
                }
            });

            // Jika validasi di modal gagal, buka kembali modal yang sama.
            @if(in_array($formGagal, ['ubah', 'reset'], true))
                document.addEventListener('DOMContentLoaded', function () {
                    new bootstrap.Modal(document.getElementById(@json($formGagal === 'ubah' ? 'modalUbahAdmin' : 'modalResetAdmin'))).show();
                });
            @endif
        </script>
    @endpush
</x-admin.admin-template>
