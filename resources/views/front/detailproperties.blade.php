<x-front.front-end-template :title="$judul" :main-label="$menuUtama" :secondary-label="$menuKedua">
    @php
        $agent = $property->agent;
        $pesanWa = 'Halo, saya tertarik dengan properti "'.$property->name.'" di GeoRestate: '.route('front.properties.detail', $property->slug);
    @endphp
    <section class="page-header page-header-modern bg-color-primary border-0 m-0">
        <div class="container position-relative z-index-2">
            <div class="row text-center text-md-start py-5">
                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="font-weight-bold text-color-light text-7 mb-0">{{ $property->name }}</h1>
                    <p class="text-color-light opacity-7 mb-0">{{ $property->lokasi() }}</p>
                    <div class="mt-3">
                        @include('front.partials.favorit-button', ['property' => $property, 'varian' => 'detail'])
                    </div>
                </div>
                <div class="col-md-4 order-1 order-md-2 align-self-center">
                    <ul class="breadcrumb breadcrumb-light d-block text-md-end text-4 mb-0">
                        <li><a href="{{ route('front.home') }}" class="text-decoration-none">Home</a></li>
                        <li><a href="{{ route('front.properties') }}" class="text-decoration-none">Properti</a></li>
                        <li class="text-upeercase active">Detail</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5 my-3">
        <div class="row">
            <div class="col-lg-9">

                <div class="row">
                    <div class="col-lg-7">
                        @if($property->gambars->isNotEmpty())
                            <div class="thumb-gallery">
                                <div class="lightbox" data-plugin-options="{'delegate': 'a', 'type': 'image', 'gallery': {'enabled': true}}">
                                    <div class="owl-carousel owl-theme manual thumb-gallery-detail show-nav-hover" id="thumbGalleryDetail">
                                        @foreach($property->gambars as $gambar)
                                            <div class="border-radius overflow-hidden">
                                                <a href="{{ $gambar->url }}">
                                                    <span class="thumb-info thumb-info-centered-info thumb-info-no-borders text-4">
                                                        <span class="thumb-info-wrapper text-4">
                                                            <img alt="Foto {{ $loop->iteration }} {{ $property->name }}" src="{{ $gambar->url }}" class="img-fluid"
                                                                 style="aspect-ratio: 3 / 2; object-fit: cover; width: 100%;"
                                                                 onerror="this.onerror=null;this.src='{{ \App\Models\Gambar::defaultUrl() }}';this.closest('a').href=this.src">
                                                            <span class="thumb-info-title text-4">
                                                                <span class="thumb-info-inner text-4"><i class="icon-magnifier icons text-4"></i></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @if($property->gambars->count() > 1)
                                    <div class="owl-carousel owl-theme manual thumb-gallery-thumbs mt" id="thumbGalleryThumbs">
                                        @foreach($property->gambars as $gambar)
                                            <div class="border-radius overflow-hidden">
                                                <img alt="" src="{{ $gambar->url }}" class="img-fluid cur-pointer" style="aspect-ratio: 3 / 2; object-fit: cover;"
                                                     onerror="this.onerror=null;this.src='{{ \App\Models\Gambar::defaultUrl() }}'">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <img src="{{ \App\Models\Gambar::defaultUrl() }}" alt="Foto belum tersedia" class="img-fluid border-radius w-100"
                                 style="aspect-ratio: 3 / 2; object-fit: cover;">
                        @endif
                    </div>
                    <div class="col-lg-5">
                        <div class="border-radius overflow-hidden">
                            <table class="table table-striped">
                                <colgroup>
                                    <col width="40%">
                                    <col width="60%">
                                </colgroup>
                                <tbody>
                                @forelse($property->daftarHarga() as $periode => $harga)
                                    <tr>
                                        <td class="bg-color-secondary text-light align-middle font-weight-semibold">Sewa / {{ $periode }}</td>
                                        <td class="text-4 font-weight-bold align-middle bg-color-secondary text-light">{{ $harga }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="bg-color-secondary text-light font-weight-semibold">Harga</td>
                                        <td class="bg-color-secondary text-light">Hubungi agen</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td class="font-weight-semibold">Kategori</td>
                                    <td>{{ $property->kategori->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold">Alamat</td>
                                    <td>
                                        {{ $property->address ?: '-' }}<br>
                                        <span class="text-2">{{ $property->lokasi() }}</span><br>
                                        <a href="#map" class="text-2" data-hash data-hash-offset="0" data-hash-offset-lg="100">(Lihat lokasi)</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold">Kamar Tidur</td>
                                    <td>{{ $property->beds }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold">Kamar Mandi</td>
                                    <td>{{ $property->baths }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold">Luas Tanah / Panjang</td>
                                    <td>{{ $property->lt }} m</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold">Luas Bangunan / Lebar</td>
                                    <td>{{ $property->lb }} m</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold">Diperbarui</td>
                                    <td>{{ $property->updated_at?->format('d-m-Y') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <h3 class="mt-5 mb-3">Deskripsi</h3>
                        <p>{!! nl2br(e($property->description ?: 'Belum ada deskripsi.')) !!}</p>

                        <hr class="solid my-5">

                        <h3 class="mt-5 mb-3">Fasilitas</h3>
                        @if($property->fasilitas->isNotEmpty())
                            <ul class="list list-icons list-secondary row m-0">
                                @foreach($property->fasilitas as $fasilitas)
                                    <li class="col-sm-6 col-lg-4"><i class="fas fa-check"></i> {{ $fasilitas->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Belum ada informasi fasilitas.</p>
                        @endif

                        <hr class="solid my-5">

                        @include('front.partials.peta-lokasi', ['property' => $property])
                    </div>
                </div>

            </div>
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-12">
                        <div class="card custom-card-info custom-card-info-shadow bg-color-primary text-color-light border-0 mb-4">
                            <div class="card-body bg-transparent p-relative p-4 my-2 text-center z-index-1">
                                <h3 class="text-color-light font-weight-semibold text-5 d-block mb-4">Hubungi Agen</h3>
                                <a href="{{ route('front.agents.detail', $agent) }}" class="text-decoration-none">
                                    <img alt="{{ $agent->hasUser->name ?? 'Agen' }}" class="img-fluid rounded-circle m-auto" src="{{ $agent->fotoUrl() }}" style="width: 110px; height: 110px; object-fit: cover;" onerror="this.onerror=null;this.src='{{ asset(\App\Models\Agent::FOTO_DEFAULT) }}'">
                                    <strong class="text-color-light font-weight-semibold text-4 line-height-5 d-block mt-3 mb-1 text-center">{{ $agent->hasUser->name ?? 'Agen' }}</strong>
                                </a>
                                @if($agent->teleponUrl())
                                    <a class="opacity-7 text-color-light d-block text-center line-height-5 text-3 mb-3" href="{{ $agent->teleponUrl() }}">{{ $agent->phone }}</a>
                                @endif
                                <div class="d-grid gap-2">
                                    @if($agent->whatsappUrl())
                                        <a href="{{ $agent->whatsappUrl($pesanWa) }}" target="_blank" rel="noopener"
                                           class="btn btn-light font-weight-semibold text-2 text-uppercase btn-py-2">
                                            <i class="fab fa-whatsapp me-1"></i> Chat WhatsApp
                                        </a>
                                    @endif
                                    @if($agent->teleponUrl())
                                        <a href="{{ $agent->teleponUrl() }}" class="btn font-weight-semibold text-2 text-uppercase btn-py-2"
                                           style="border: 2px solid #fff; color: #fff; background: transparent;">
                                            <i class="fas fa-phone me-1"></i> Telepon
                                        </a>
                                    @endif
                                    @unless($agent->whatsappUrl() || $agent->teleponUrl())
                                        <span class="opacity-7 text-2">Agen belum mencantumkan nomor telepon.</span>
                                    @endunless
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-12" id="tanya-agen">
                        @php($penanya = auth()->user())
                        <div class="card custom-card-info bg-color-quaternary border-0 mb-4">
                            <div class="card-body bg-transparent p-relative p-4 z-index-1">
                                <h3 class="text-color-dark font-weight-semibold text-5 d-block mt-1 mb-2">Tanya Agen</h3>
                                <p class="text-2 mb-3">Kirim pertanyaan tentang properti ini. Agen akan menghubungi Anda.</p>

                                @if(session('inquiry_success'))
                                    <div class="alert alert-success text-2">{{ session('inquiry_success') }}</div>
                                @endif

                                {{-- Jangan pakai class "contact-form": class itu dipakai script AJAX bawaan template. --}}
                                <form class="form-style-3" action="{{ route('front.inquiry.store', $property->slug) }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-2">
                                        <input type="text" name="name" maxlength="100" required placeholder="Nama *"
                                               value="{{ old('name', $penanya?->name) }}"
                                               class="form-control bg-color-light box-shadow-none border-0 @error('name') is-invalid @enderror">
                                        @error('name')<div class="text-danger text-2 mt-1">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="email" name="email" maxlength="100" required placeholder="E-mail *"
                                               value="{{ old('email', $penanya?->email) }}"
                                               class="form-control bg-color-light box-shadow-none border-0 @error('email') is-invalid @enderror">
                                        @error('email')<div class="text-danger text-2 mt-1">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="text" name="phone" maxlength="30" placeholder="No. WhatsApp (opsional)"
                                               value="{{ old('phone') }}"
                                               class="form-control bg-color-light box-shadow-none border-0 @error('phone') is-invalid @enderror">
                                        @error('phone')<div class="text-danger text-2 mt-1">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <textarea name="message" rows="4" maxlength="2000" required placeholder="Pesan *"
                                                  class="form-control bg-color-light box-shadow-none border-0 @error('message') is-invalid @enderror">{{ old('message', 'Halo, saya tertarik dengan "'.$property->name.'". Apakah masih tersedia?') }}</textarea>
                                        @error('message')<div class="text-danger text-2 mt-1">{{ $message }}</div>@enderror
                                    </div>
                                    {{-- Honeypot anti-spam: disembunyikan dari pengguna, harus tetap kosong. --}}
                                    <div style="position: absolute; left: -10000px;" aria-hidden="true">
                                        <label for="websiteTanya">Website</label>
                                        <input type="text" name="website" id="websiteTanya" tabindex="-1" autocomplete="off">
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-secondary font-weight-semibold border-0 text-2 text-uppercase btn-py-2" type="submit">Kirim Pertanyaan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if($dataSerupa->isNotEmpty())
                        <div class="col-12 col-sm-6 col-lg-12">
                            <h3 class="mt-2 mb-3 font-weight-semibold text-5">Properti Serupa</h3>
                            @foreach($dataSerupa as $serupa)
                                <div class="mb-4">
                                    @include('front.partials.property-card', ['property' => $serupa, 'periode' => null])
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <section class="section section-height-3 bg-secondary border-0 m-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9 text-center text-lg-start mb-4 mb-lg-0">
                    <h2 class="mb-4 text-color-light mb-0">Belum menemukan yang <span class="font-weight-extra-bold">cocok</span>?</h2>
                    <p class="font-weight-semibold text-color-light text-4 opacity-7 mb-0">Lihat properti lain atau hubungi kami.</p>
                </div>
                <div class="col-lg-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('front.properties') }}" class="btn btn-primary font-weight-semibold border-0 text-3 text-uppercase mt-4 btn-py-3">Cari Properti</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-front.front-end-template>
