<x-auth-card judul="Verifikasi Email" subjudul="Terima kasih telah mendaftar! Silakan klik tautan verifikasi yang kami kirim ke email Anda.">
    @if(session('status') === 'verification-link-sent')
        <div class="alert alert-success">Tautan verifikasi baru sudah dikirim ke email Anda.</div>
    @endif
    <div class="d-flex flex-wrap gap-2 justify-content-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-success">Kirim Ulang Email Verifikasi</button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-light">Keluar</button>
        </form>
    </div>
</x-auth-card>
