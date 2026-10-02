<x-front.front-end-template :title="$judul" :main-label="$menuUtama" :secondary-label="$menuKedua">
    @php($kontak = config('georestate.kontak'))
    <section class="page-header page-header-modern bg-color-primary border-0 m-0">
        <div class="container position-relative z-index-2">
            <div class="row text-center text-md-start py-5">
                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="font-weight-bold text-color-light text-8 mb-0">Kontak</h1>
                    <p class="text-color-light opacity-7 mb-0">Ada pertanyaan? Kirim pesan kepada kami.</p>
                </div>
                <div class="col-md-4 order-1 order-md-2 align-self-center">
                    <ul class="breadcrumb breadcrumb-light d-block text-md-end text-4 mb-0">
                        <li><a href="{{ route('front.home') }}" class="text-decoration-none">Home</a></li>
                        <li class="text-upeercase active">Kontak</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5 my-3">
        <div class="row">
            <div class="col-lg-9">
                <div class="card custom-card-info bg-color-quaternary border-0 mb-4">
                    <div class="card-body bg-transparent p-relative p-4 m-2 z-index-1">
                        <h3 class="text-color-dark font-weight-semibold text-5 d-block mt-1 mb-2">Hubungi Kami</h3>
                        <p>Kami siap membantu Anda menemukan properti atau menjawab pertanyaan lainnya.</p>

                        @if(session('success'))
                            <div class="alert alert-success mt-3">{{ session('success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger mt-3">Periksa kembali isian formulir Anda.</div>
                        @endif

                        {{-- Jangan pakai class "contact-form": class itu dipakai script AJAX bawaan template. --}}
                        <form class="form-style-3" action="{{ route('front.contact.store') }}" method="POST" id="formKontak">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6 mb-2">
                                    <input type="text" value="{{ old('name') }}" maxlength="100" class="form-control bg-color-light box-shadow-none border-0 @error('name') is-invalid @enderror" name="name" id="name" required placeholder="Nama *">
                                    @error('name')<div class="text-danger text-2 mt-1">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6 mb-2">
                                    <input type="email" value="{{ old('email') }}" maxlength="100" class="form-control bg-color-light box-shadow-none border-0 @error('email') is-invalid @enderror" name="email" id="email" required placeholder="E-mail *">
                                    @error('email')<div class="text-danger text-2 mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 mb-2">
                                    <input type="text" value="{{ old('phone') }}" maxlength="30" class="form-control bg-color-light box-shadow-none border-0 @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="No. Telepon / WhatsApp">
                                    @error('phone')<div class="text-danger text-2 mt-1">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6 mb-2">
                                    <input type="text" value="{{ old('subject') }}" maxlength="150" class="form-control bg-color-light box-shadow-none border-0 @error('subject') is-invalid @enderror" name="subject" id="subject" placeholder="Subjek">
                                    @error('subject')<div class="text-danger text-2 mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col mb-2">
                                    <textarea maxlength="5000" rows="8" class="form-control bg-color-light box-shadow-none border-0 @error('message') is-invalid @enderror" name="message" id="message" required placeholder="Pesan *">{{ old('message') }}</textarea>
                                    @error('message')<div class="text-danger text-2 mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            {{-- Honeypot anti-spam: disembunyikan dari pengguna, harus tetap kosong. --}}
                            <div style="position: absolute; left: -10000px;" aria-hidden="true">
                                <label for="website">Website</label>
                                <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                            </div>
                            @error('website')<div class="text-danger text-2 mb-2">{{ $message }}</div>@enderror
                            <div class="row">
                                <div class="form-group col mb-0">
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-secondary font-weight-semibold border-0 p-relative text-2 text-uppercase mt-1 btn-px-4 btn-py-2 mb-2" type="submit">Kirim Pesan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                @if($kontak['alamat'])
                    <h3 class="mt-2 mb-1 font-weight-semibold text-5">Alamat</h3>
                    <p class="mt-0 mb-4">{!! nl2br(e($kontak['alamat'])) !!}</p>
                @endif
                @if($kontak['email'])
                    <h3 class="mt-2 mb-1 font-weight-semibold text-5">Email</h3>
                    <p class="mt-0 mb-4"><a href="mailto:{{ $kontak['email'] }}">{{ $kontak['email'] }}</a></p>
                @endif
                @if($kontak['telepon'])
                    <h3 class="mt-2 mb-1 font-weight-semibold text-5">Telepon</h3>
                    <p class="mt-0 mb-4"><a href="tel:{{ preg_replace('/[^\d+]/', '', $kontak['telepon']) }}">{{ $kontak['telepon'] }}</a></p>
                @endif

                <div class="card custom-card-info custom-card-info-shadow bg-color-primary text-color-light border-0 mb-4">
                    <div class="card-body bg-transparent p-4 text-center">
                        <h3 class="text-color-light font-weight-semibold text-5 mb-3">Tanya Langsung ke Agen</h3>
                        <p class="text-color-light opacity-7">Setiap halaman properti memiliki tombol WhatsApp dan telepon agen.</p>
                        <a href="{{ route('front.properties') }}" class="btn btn-light font-weight-semibold text-2 text-uppercase btn-px-4 btn-py-2">Cari Properti</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front.front-end-template>
