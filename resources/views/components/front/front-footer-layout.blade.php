<div>
    @php($kontak = config('georestate.kontak'))
    <footer id="footer" class="footer-georestate m-0">
        {{-- Lengkungan atas footer --}}
        <svg class="footer-georestate__gelombang" viewBox="0 0 1440 60" preserveAspectRatio="none" aria-hidden="true">
            <path d="M0 60 L0 30 C 240 0, 480 50, 720 30 S 1200 0, 1440 25 L1440 60 Z" fill="#0f3b73"/>
        </svg>

        <div class="container position-relative">
            <div class="row pt-5 pb-4 gy-4">
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('front.home') }}" class="d-inline-block mb-3 no-footer-css">
                        <img src="{{ asset('images/logo/logo-light.svg') }}" alt="{{ config('georestate.nama') }}" width="176" height="40">
                    </a>
                    <p class="footer-georestate__teks mb-4">{{ config('georestate.tagline') }}. Semua listing diperiksa admin sebelum tayang, dan Anda bisa langsung menghubungi agennya.</p>

                    <ul class="footer-georestate__kontak list-unstyled mb-0">
                        @if($kontak['alamat'])
                            <li><i class="fas fa-map-marker-alt"></i><span>{!! nl2br(e($kontak['alamat'])) !!}</span></li>
                        @endif
                        @if($kontak['telepon'])
                            <li><i class="fas fa-phone-alt"></i><a class="no-footer-css" href="tel:{{ preg_replace('/[^\d+]/', '', $kontak['telepon']) }}">{{ $kontak['telepon'] }}</a></li>
                        @endif
                        @if($kontak['email'])
                            <li><i class="fas fa-envelope"></i><a class="no-footer-css" href="mailto:{{ $kontak['email'] }}">{{ $kontak['email'] }}</a></li>
                        @endif
                        @if(!$kontak['alamat'] && !$kontak['telepon'] && !$kontak['email'])
                            <li><i class="fas fa-comment-dots"></i><a class="no-footer-css" href="{{ route('front.contact') }}">Kirim pesan lewat halaman Kontak</a></li>
                        @endif
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <h5 class="footer-georestate__judul">Properti</h5>
                    <ul class="footer-georestate__tautan list-unstyled mb-0">
                        @foreach(\App\Http\Controllers\Front\PropertiesController::PERIODE as $value => $label)
                            <li><a class="no-footer-css" href="{{ route('front.properties', ['periode' => $value]) }}">Sewa {{ $label }}</a></li>
                        @endforeach
                        <li><a class="no-footer-css" href="{{ route('front.properties') }}">Semua Properti</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <h5 class="footer-georestate__judul">Tautan</h5>
                    <ul class="footer-georestate__tautan list-unstyled mb-0">
                        <li><a class="no-footer-css" href="{{ route('front.agents') }}">Agen</a></li>
                        <li><a class="no-footer-css" href="{{ route('front.about') }}">Tentang Kami</a></li>
                        <li><a class="no-footer-css" href="{{ route('front.contact') }}">Kontak</a></li>
                        <li><a class="no-footer-css" href="{{ route('login') }}">Masuk</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="footer-georestate__ajakan">
                        <span class="footer-georestate__ajakan-ikon"><i class="fas fa-home"></i></span>
                        <h5 class="text-color-light mb-2">Punya properti untuk disewakan?</h5>
                        <p class="mb-3">Daftar sebagai agen dan pasang listing kos, kamar, rumah, atau apartemen Anda secara gratis.</p>
                        <a href="{{ route('register') }}" class="footer-georestate__tombol no-footer-css"><i class="fas fa-user-plus"></i> Daftar sebagai Agen</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-georestate__bawah">
            <div class="container">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 py-3">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ config('georestate.nama') }}. All rights reserved.</p>
                    <p class="mb-0">Peta &copy; <a class="no-footer-css" href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a></p>
                </div>
            </div>
        </div>
    </footer>
</div>
