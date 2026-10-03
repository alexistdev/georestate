@include('errors.layout', [
    'kode' => 503,
    'judul' => 'Lisensi aplikasi tidak valid',
    'pesan' => 'Lisensi untuk aplikasi ini belum aktif, sudah kedaluwarsa, atau tidak dapat diverifikasi. Silakan hubungi administrator.',
    'tombolBeranda' => false,
])
