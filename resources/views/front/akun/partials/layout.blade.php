{{-- Header halaman Akun Saya (pencari properti). Variabel: $judulHalaman --}}
<section class="page-header page-header-modern bg-color-primary border-0 m-0">
    <div class="container position-relative z-index-2">
        <div class="row text-center text-md-start py-5">
            <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                <h1 class="font-weight-bold text-color-light text-8 mb-0">{{ $judulHalaman }}</h1>
                <p class="text-color-light opacity-7 mb-0">Akun {{ auth()->user()->name }}</p>
            </div>
            <div class="col-md-4 order-1 order-md-2 align-self-center">
                <ul class="breadcrumb breadcrumb-light d-block text-md-end text-4 mb-0">
                    <li><a href="{{ route('front.home') }}" class="text-decoration-none">Home</a></li>
                    <li class="text-upeercase active">Akun Saya</li>
                </ul>
            </div>
        </div>
    </div>
</section>
