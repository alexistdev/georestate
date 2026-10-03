<x-front.front-end-template :title="$judul" :main-label="$menuUtama" :secondary-label="$menuKedua">
    <section class="page-header page-header-modern page-header-georestate border-0 m-0">
        <div class="container position-relative z-index-2">
            <div class="row text-center text-md-start py-5">
                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="font-weight-bold text-color-light text-8 mb-0">Tentang Kami</h1>
                    <p class="text-color-light opacity-7 mb-0">{{ config('georestate.tagline') }}</p>
                </div>
                <div class="col-md-4 order-1 order-md-2 align-self-center">
                    <ul class="breadcrumb breadcrumb-light d-block text-md-end text-4 mb-0">
                        <li><a href="{{ route('front.home') }}" class="text-decoration-none">Home</a></li>
                        <li class="text-upeercase active">Tentang</li>
                    </ul>
                </div>
            </div>
        </div>
        <svg class="page-header-georestate__gelombang" viewBox="0 0 1440 50" preserveAspectRatio="none" aria-hidden="true">
            <path d="M0 30 C 240 55, 480 5, 720 25 S 1200 50, 1440 15 L1440 50 L0 50 Z" fill="#f3f7fc"/>
        </svg>
    </section>

    {{-- Teks di halaman ini bersifat umum; sesuaikan dengan profil usaha Anda. --}}
    <section class="bagian-listing">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-9">
                <p class="font-weight-medium text-4">
                    {{ config('georestate.nama') }} adalah platform yang mempertemukan pencari properti sewaan dengan
                    <span class="highlight highlight-primary highlight-bg-opacity highlight-animated px-0" data-appear-animation="highlight-animated-start" data-appear-animation-delay="200" data-plugin-options="{'flagClassOnly': true}">agen dan pemilik properti</span>.
                </p>
                <p class="text-3-5 line-height-9">
                    Temukan kos, kamar, rumah, apartemen, dan ruko yang disewakan secara harian, bulanan, maupun tahunan.
                    Setiap listing ditinjau oleh tim kami sebelum ditayangkan, sehingga informasi yang Anda lihat lebih dapat dipercaya.
                </p>
                <ul class="list list-icons list-primary my-4">
                    <li><i class="fas fa-check"></i> Pencarian berdasarkan kategori, wilayah, periode sewa, dan rentang harga.</li>
                    <li><i class="fas fa-check"></i> Foto, fasilitas, dan harga ditampilkan dengan jelas di setiap listing.</li>
                    <li><i class="fas fa-check"></i> Hubungi agen langsung melalui WhatsApp atau telepon.</li>
                    <li><i class="fas fa-check"></i> Listing ditinjau admin sebelum tampil di website.</li>
                </ul>

                <h3 class="mt-5 mb-2">Untuk Pencari Properti</h3>
                <p class="text-3-5 line-height-9">
                    Gunakan halaman <a href="{{ route('front.properties') }}">Cari Properti</a> untuk menyaring listing sesuai kebutuhan Anda,
                    lalu hubungi agen langsung dari halaman detail properti.
                </p>

                <h3 class="mt-5 mb-2">Untuk Agen &amp; Pemilik</h3>
                <p class="text-3-5 line-height-9">
                    <a href="{{ route('register') }}">Daftar sebagai agen</a>, lengkapi listing Anda dengan foto, fasilitas, dan harga,
                    lalu listing akan tayang setelah disetujui admin.
                </p>
            </div>
            <div class="col-lg-3">
                <div class="card custom-card-info custom-card-info-shadow bg-color-primary text-color-light border-0 mb-4">
                    <div class="card-body bg-transparent p-4 text-center">
                        <h3 class="text-color-light font-weight-semibold text-5 mb-3">Ada Pertanyaan?</h3>
                        <p class="text-color-light opacity-7">Tim kami siap membantu Anda.</p>
                        <a href="{{ route('front.contact') }}" class="btn btn-light font-weight-semibold text-2 text-uppercase btn-px-4 btn-py-2">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</x-front.front-end-template>
