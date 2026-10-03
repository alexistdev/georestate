<x-front.front-end-template :title="$judul" :main-label="$menuUtama" :secondary-label="$menuKedua">
    @include('front.akun.partials.layout', ['judulHalaman' => 'Ubah Password'])

    <div class="container py-5 my-3">
        <div class="row">
            <div class="col-lg-3">
                @include('front.akun.partials.menu')
            </div>
            <div class="col-lg-6">
                @if(session('status') === 'password-updated')
                    <div class="alert alert-success">Password berhasil diubah.</div>
                @endif

                <div class="card custom-card-info custom-card-info-shadow border-0">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('password.update') }}" class="form-style-3">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini *</label>
                                <input type="password" name="current_password" id="current_password" required autocomplete="current-password"
                                       class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">
                                @error('current_password', 'updatePassword')<div class="text-danger text-2 mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password Baru *</label>
                                <input type="password" name="password" id="password" required autocomplete="new-password"
                                       class="form-control @error('password', 'updatePassword') is-invalid @enderror">
                                @error('password', 'updatePassword')<div class="text-danger text-2 mt-1">{{ $message }}</div>@enderror
                                <small class="text-2">Minimal 8 karakter.</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-label">Ulangi Password Baru *</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-secondary font-weight-semibold text-uppercase btn-px-4 btn-py-2">Simpan Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front.front-end-template>
