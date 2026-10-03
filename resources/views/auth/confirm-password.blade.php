<x-auth-card judul="Konfirmasi Password" subjudul="Halaman ini dilindungi. Masukkan password Anda untuk melanjutkan.">
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" required autocomplete="current-password"
                   class="form-control @error('password') is-invalid @enderror">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-success w-100">Konfirmasi</button>
    </form>
</x-auth-card>
