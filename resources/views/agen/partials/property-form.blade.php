{{--
    Form tambah/edit listing.
    Variabel: $action (url), $property (null saat tambah), $dataProvinsi, $dataKategori, $dataFasilitas
--}}
@php
    $isEdit = isset($property);
    $kecamatanAwal = $isEdit ? $property->kecamatan : null;
    $provinsiIdAwal = $kecamatanAwal?->kabupaten?->provinsi_id;
    $provinsiAwal = old('provinsi', $provinsiIdAwal ? base64_encode($provinsiIdAwal) : null);
    $kabupatenAwal = old('kabupaten', $kecamatanAwal?->kabupaten_id);
    $kecamatanIdAwal = old('kecamatan', $kecamatanAwal?->id);
    // Setelah validasi gagal, pakai pilihan terakhir (bisa kosong); selain itu pakai data listing.
    $fasilitasTerpilih = array_map('intval', !empty(old())
        ? old('fasilitas', [])
        : ($isEdit ? $property->fasilitas->pluck('id')->all() : []));
@endphp

@error('error')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

<form action="{{ $action }}" id="formProperty" method="post" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PATCH')
    @endif
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="name">Judul Listing <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                               value="{{ old('name', $property->name ?? '') }}" placeholder="Masukkan Judul">
                        @error('name')
                        <div class="text-sm text-danger errorMessage">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label" for="deskripsi">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="deskripsi" name="description"
                                  placeholder="Masukkan Deskripsi" rows="5">{{ old('description', $property->description ?? '') }}</textarea>
                        @error('description')
                        <div class="text-sm text-danger errorMessage">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Detail Property</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="kategorix">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('kategori') is-invalid @enderror" id="kategorix" name="kategori">
                                    <option value="">=Pilih=</option>
                                    @foreach($dataKategori as $kategori)
                                        <option value="{{ $kategori->id }}" @selected($kategori->id == old('kategori', $property->kategori_id ?? null))>{{ $kategori->name }}</option>
                                    @endforeach
                                </select>
                                @error('kategori')
                                <div class="text-sm text-danger mt-1 errorMessage">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="luas_tanah">Luas Tanah / Panjang Ruangan (m) <span class="text-danger">*</span></label>
                                <input type="number" name="lt" min="0" class="form-control @error('lt') is-invalid @enderror" id="luas_tanah"
                                       placeholder="0" value="{{ old('lt', $property->lt ?? '') }}">
                                @error('lt')
                                <div class="text-sm text-danger mt-1 errorMessage">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="luas_bangunan">Luas Bangunan / Lebar Ruangan (m) <span class="text-danger">*</span></label>
                                <input type="number" name="lb" min="0" class="form-control @error('lb') is-invalid @enderror" id="luas_bangunan"
                                       placeholder="0" value="{{ old('lb', $property->lb ?? '') }}">
                                @error('lb')
                                <div class="text-sm text-danger mt-1 errorMessage">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="kamar_tidur">Jumlah Kamar Tidur</label>
                                <input type="number" name="kamar_tidur" class="form-control @error('kamar_tidur') is-invalid @enderror" id="kamar_tidur"
                                       placeholder="0" min="0" max="99" value="{{ old('kamar_tidur', $property->beds ?? '') }}">
                                @error('kamar_tidur')
                                <div class="text-sm text-danger mt-1 errorMessage">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="kamar_mandi">Jumlah Kamar Mandi</label>
                                <input type="number" name="kamar_mandi" class="form-control @error('kamar_mandi') is-invalid @enderror" id="kamar_mandi"
                                       placeholder="0" min="0" max="99" value="{{ old('kamar_mandi', $property->baths ?? '') }}">
                                @error('kamar_mandi')
                                <div class="text-sm text-danger mt-1 errorMessage">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Harga Sewa <span class="text-danger">*</span></h5>
                    <p class="text-muted mb-0 mt-1">Isi minimal salah satu periode. Kosongkan periode yang tidak tersedia.</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach(\App\Models\Property::PERIODE_HARGA as $kolom => $label)
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label" for="{{ $kolom }}">Per {{ $label }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" min="1" name="{{ $kolom }}" class="form-control @error($kolom) is-invalid @enderror" id="{{ $kolom }}"
                                               placeholder="0" value="{{ old($kolom, $property->{$kolom} ?? '') }}">
                                    </div>
                                    @error($kolom)
                                    <div class="text-sm text-danger mt-1 errorMessage">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Fasilitas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($dataFasilitas as $fasilitas)
                            <div class="col-lg-4 col-sm-6">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="fasilitas[]" value="{{ $fasilitas->id }}"
                                           id="fasilitas{{ $fasilitas->id }}" @checked(in_array($fasilitas->id, $fasilitasTerpilih, true))>
                                    <label class="form-check-label" for="fasilitas{{ $fasilitas->id }}">{{ $fasilitas->name }}</label>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Belum ada data fasilitas.</p>
                        @endforelse
                    </div>
                    @if($errors->has('fasilitas') || $errors->has('fasilitas.*'))
                        <div class="text-sm text-danger mt-1">{{ $errors->first('fasilitas') ?: $errors->first('fasilitas.*') }}</div>
                    @endif
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        {{ $isEdit ? 'Tambah Foto' : 'Foto Property' }}
                        @unless($isEdit)<span class="text-danger">*</span>@endunless
                    </h5>
                    <p class="text-muted mb-0 mt-1">
                        Maksimal {{ \App\Models\Property::MAX_GAMBAR }} foto per listing, format JPG/PNG/WebP, ukuran maksimal 2 MB per foto.
                        @unless($isEdit) Foto pertama menjadi foto utama. @endunless
                    </p>
                </div>
                <div class="card-body">
                    <input type="file" name="gambar[]" id="gambar" multiple accept="image/jpeg,image/png,image/webp"
                           class="form-control @if($errors->has('gambar') || $errors->has('gambar.*')) is-invalid @endif">
                    @if($errors->has('gambar') || $errors->has('gambar.*'))
                        <div class="text-sm text-danger mt-1 errorMessage">{{ $errors->first('gambar') ?: $errors->first('gambar.*') }}</div>
                    @endif
                    <div class="row g-2 mt-2" id="previewGambar"></div>
                </div>
            </div>
            <!-- end card -->

            <div class="text-end mb-3">
                <a href="{{ $isEdit ? route('agn.lists.show', $property) : route('agn.lists') }}" class="btn btn-light w-sm">Batal</a>
                <button type="submit" class="btn btn-success w-sm">{{ $isEdit ? 'Simpan & Ajukan Ulang' : 'Simpan' }}</button>
            </div>
        </div>
        <!-- end col -->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Alamat</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="provinsiX" class="form-label">Provinsi <span class="text-danger">*</span></label>
                            <select class="form-select" id="provinsiX" name="provinsi">
                                <option value="">=Pilih=</option>
                                @foreach($dataProvinsi as $provinsi)
                                    <option value="{{ base64_encode($provinsi->id) }}" @selected(base64_encode($provinsi->id) === $provinsiAwal)>{{ $provinsi->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <label for="kabupatenX" class="form-label">Kabupaten <span class="text-danger">*</span></label>
                            <select class="form-select" id="kabupatenX" name="kabupaten">
                                <option value="">=Pilih=</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <label for="kecamatanX" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                            <select class="form-select" id="kecamatanX" name="kecamatan">
                                <option value="">=Pilih=</option>
                            </select>
                            @error('kecamatan')
                            <div class="text-sm text-danger errorMessage">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <label class="form-label" for="detail_alamat">Detail Alamat</label>
                            <textarea class="form-control" id="detail_alamat" name="address"
                                      placeholder="Masukkan Detail Alamat" rows="3">{{ old('address', $property->address ?? '') }}</textarea>
                            @error('address')
                            <div class="text-sm text-danger errorMessage">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</form>

@push('customCSS')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endpush

@push('customJS')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            let provinsi = $('#provinsiX');
            let kabupaten = $('#kabupatenX');
            let kecamatan = $('#kecamatanX');
            let formInput = $("form#formProperty :input");
            let oldKabupaten = @json($kabupatenAwal);
            let oldKecamatan = @json($kecamatanIdAwal);

            provinsi.select2();
            kabupaten.select2();
            kecamatan.select2();

            if(provinsi.val()){
                getKabupaten(provinsi.val(),kabupaten,kecamatan,oldKabupaten)
            }

            formInput.on('keypress',function(){
                makeValid();
            })

            function makeValid(){
                let pesanError = $('.errorMessage');
                pesanError.removeClass('text-danger');
                pesanError.text("");
                formInput.each(function(){
                    $(this).removeClass('is-invalid');
                });
            }

            function getKabupaten(idProvinsi,kabupaten,kecamatan,selectedKabupaten = null){
                let kab = '{{ route('agn.lists.kabupaten','__ID__') }}';
                let urlGetKabupaten = kab.replace('__ID__', idProvinsi);
                kabupaten.find('option').not(':first').remove();
                kecamatan.find('option').not(':first').remove();
                if(!idProvinsi){
                    return;
                }
                $.ajax({
                    url: urlGetKabupaten,
                    type: 'get',
                    dataType: 'json',
                    success: function (response) {
                        fillOptions(kabupaten, response, selectedKabupaten);
                        if (selectedKabupaten) {
                            getKecamatan(selectedKabupaten, kecamatan, oldKecamatan);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    }
                });
            }

            function getKecamatan(idKabupaten,kecamatan,selectedKecamatan = null){
                let kec = '{{ route('agn.lists.kecamatan','__ID__') }}';
                let urlGetKecamatan = kec.replace('__ID__', idKabupaten);
                kecamatan.find('option').not(':first').remove();
                if(!idKabupaten){
                    return;
                }
                $.ajax({
                    url: urlGetKecamatan,
                    type: 'get',
                    dataType: 'json',
                    success: function (response) {
                        fillOptions(kecamatan, response, selectedKecamatan);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    }
                });
            }

            /** Isi <select> dengan data {id, name}; pakai new Option agar teks tidak dianggap HTML */
            function fillOptions(select, response, selectedId = null){
                (response || []).forEach(function (item) {
                    let isSelected = selectedId !== null && String(item.id) === String(selectedId);
                    select.append(new Option(item.name, item.id, isSelected, isSelected));
                });
                select.trigger('change.select2');
            }

            provinsi.change(function () {
                getKabupaten($(this).val(),kabupaten,kecamatan);
                makeValid();
            });

            kabupaten.change(function () {
                getKecamatan($(this).val(), kecamatan);
            });

            /** Pratinjau foto yang dipilih sebelum diupload */
            $('#gambar').on('change', function () {
                let preview = $('#previewGambar').empty();
                Array.from(this.files).forEach(function (file) {
                    let img = $('<img class="img-fluid rounded" style="height:100px;width:100%;object-fit:cover">')
                        .attr('src', URL.createObjectURL(file))
                        .attr('alt', file.name);
                    preview.append($('<div class="col-4 col-md-3"></div>').append(img));
                });
            });
        });
    </script>
@endpush
