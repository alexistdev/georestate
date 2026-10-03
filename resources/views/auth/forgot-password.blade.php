<x-auth-card judul="Lupa Password" subjudul="Masukkan email akun Anda, kami kirimkan tautan untuk membuat password baru.">
    @if(\App\Support\Fitur::emailAktif())
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       class="form-control @error('email') is-invalid @enderror">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-success w-100">Kirim Tautan Reset Password</button>
        </form>
    @else
        <div class="alert alert-info mb-0">
            Reset password lewat email belum tersedia. Silakan hubungi administrator
            @if(config('georestate.kontak.email') || config('georestate.kontak.telepon'))
                ({{ collect([config('georestate.kontak.email'), config('georestate.kontak.telepon')])->filter()->implode(' / ') }})
            @endif
            untuk mereset password Anda.
        </div>
    @endif
</x-auth-card>
