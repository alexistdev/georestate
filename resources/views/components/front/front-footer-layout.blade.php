<div>
    @php($kontak = config('georestate.kontak'))
    <footer id="footer" class="m-0">
        <div class="container py-3">
            <div class="row py-5">
                <div class="col-md-4 col-lg-5">
                    <h4 class="mb-3">{{ config('georestate.nama') }}</h4>
                    <p class="mb-2">{{ config('georestate.tagline') }}</p>
                    <p class="mb-0">
                        @if($kontak['alamat']){!! nl2br(e($kontak['alamat'])) !!}<br>@endif
                        @if($kontak['telepon'])Telepon : {{ $kontak['telepon'] }}<br>@endif
                        @if($kontak['email'])Email : <a class="text-color-secondary" href="mailto:{{ $kontak['email'] }}">{{ $kontak['email'] }}</a>@endif
                    </p>
                </div>
                <div class="col-md-4 col-lg-3">
                    <h4 class="mb-3">Properti</h4>
                    <nav class="nav-footer">
                        <ul class="list-unstyled mb-0">
                            @foreach(\App\Http\Controllers\Front\PropertiesController::PERIODE as $value => $label)
                                <li>
                                    <a href="{{ route('front.properties', ['periode' => $value]) }}" class="custom-color-2 text-decoration-none">
                                        Sewa {{ $label }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
                <div class="col-md-4 col-lg-4">
                    <h4 class="mb-3">Tautan</h4>
                    <nav class="nav-footer">
                        <ul class="list-unstyled mb-0">
                            <li><a href="{{ route('front.agents') }}" class="custom-color-2 text-decoration-none">Agen</a></li>
                            <li><a href="{{ route('front.about') }}" class="custom-color-2 text-decoration-none">Tentang Kami</a></li>
                            <li><a href="{{ route('front.contact') }}" class="custom-color-2 text-decoration-none">Kontak</a></li>
                            <li><a href="{{ route('register') }}" class="custom-color-2 text-decoration-none">Daftar Agen</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="footer-copyright pb-0">
            <div class="container">
                <div class="row ">
                    <div class="col text-center py-4">
                        <p>© {{ date('Y') }} {{ config('georestate.nama') }}. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
