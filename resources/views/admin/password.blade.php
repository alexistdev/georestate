<x-admin.admin-template :title="$judul">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Ubah Password</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-lg-8">
            @if(session('status') === 'password-updated')
                <div class="alert alert-success">Password berhasil diubah.</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                            <input type="password" name="current_password" id="current_password" autocomplete="current-password" required
                                   class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" autocomplete="new-password" required
                                   class="form-control @error('password', 'updatePassword') is-invalid @enderror">
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Minimal 8 karakter.</div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Ulangi Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" required
                                   class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin.admin-template>
