<x-agent.agent-template :title="$title" :menu-utama="$menuUtama" :menu-kedua="$menuKedua">
    @push('customCSS')
        <x-admin.datatable-c-s-s/>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    @endpush
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">My Listing Properties</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('agn.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">My Listing Properties</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <form  action="{{route('agn.lists.save')}}"  id="formProperty" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="name">Listing Title <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{old('name')}}"
                                   placeholder="Masukkan Title">
                            @error('name')
                                <div class="text-sm text-danger errorMessage">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="deskripsi">Deskripsi</label>
                            <div id="editor">
                                <textarea class="form-control @error('description') is-invalid @enderror" id="deskripsi" name="description"
                                          placeholder="Masukkan Deskripsi" rows="3">{{old('description')}}</textarea>
                                @error('description')
                                <div class="text-sm text-danger errorMessage">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->


                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#addproduct-general-info"
                                   role="tab">
                                    Detail Info Property
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#addproduct-metadata" role="tab">
                                    <span  class="@if($errors->has('feature1') || $errors->has('feature2') || $errors->has('feature3') || $errors->has('feature4'))text-danger @endif" >Feature (Optional) </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- end card header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="addproduct-general-info" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="luas_tanah">Luas Tanah /Panjang
                                                Ruangan <span class="text-danger">*</span></label>
                                            <input type="number" name="lt" class="form-control @error('lt') is-invalid @enderror" id="luas_tanah"
                                                   placeholder="0" value="{{old('lt')}}">
                                            @error('lt')
                                            <div class="text-sm text-danger mt-1 errorMessage">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="luas_bangunan">Luas Bangunan / Lebar
                                                Ruangan <span class="text-danger">*</span></label>
                                            <input type="number" name="lb" class="form-control @error('lb') is-invalid @enderror" id="luas_bangunan"
                                                   placeholder="0" value="{{old('lb')}}">
                                            @error('lb')
                                            <div class="text-sm text-danger mt-1 errorMessage">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="price">Harga Sewa /
                                                Bulan <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text " id="price">Rp</span>
                                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price"
                                                       placeholder="0" value="{{old('price')}}">
                                            </div>
                                            @error('price')
                                            <div class="text-sm text-danger mt-1 errorMessage">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="kategorix">Kategori <span class="text-danger">*</span></label>
                                            <select class="form-select @error('kategori') is-invalid @enderror" id="kategorix" name="kategori" >
                                                <option value="">=Pilih=</option>
                                                @foreach($dataKategori as $kategori)
                                                    <option value="{{$kategori->id}}" @if($kategori->id == old('kategori')) SELECTED @endif>{{$kategori->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('kategori')
                                            <div class="text-sm text-danger mt-1 errorMessage">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end tab-pane -->

                            <div class="tab-pane" id="addproduct-metadata" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="feature1">Feature 1</label>
                                            <input type="text" name="feature1" class="form-control @error('feature1') is-invalid @enderror" placeholder="Masukkan Featur 1"
                                                   id="feature1" value="{{old('feature1')}}">
                                            @error('feature1')
                                            <div class="text-sm text-danger mt-1 errorMessage">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="feature2">Feature 2</label>
                                            <input type="text" name="feature2" class="form-control @error('feature2') is-invalid @enderror" placeholder="Masukkan Featur 2"
                                                   id="feature2" value="{{old('feature2')}}">
                                            @error('feature2')
                                            <div class="text-sm text-danger mt-1 errorMessage">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="feature3">Feature 3</label>
                                            <input type="text" name="feature3" class="form-control @error('feature3') is-invalid @enderror" placeholder="Masukkan Featur 3"
                                                   id="feature3" value="{{old('feature3')}}">
                                            @error('feature3')
                                            <div class="text-sm text-danger mt-1 errorMessage">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="feature4">Feature 4</label>
                                            <input type="text" name="feature4" class="form-control @error('feature4') is-invalid @enderror" placeholder="Masukkan Featur 4"
                                                   id="feature4" value="{{old('feature4')}}">
                                            @error('feature4')
                                            <div class="text-sm text-danger mt-1 errorMessage">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                            </div>
                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->
                        <p class="text-danger mt-5"> * wajib diisi</p>
                    </div>
                    <!-- end card body -->

                </div>
                <!-- end card -->
                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">Submit</button>
                </div>
            </div>
            <!-- end col -->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Address </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="provinsiX" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <select class="form-select" id="provinsiX" name="provinsi" >
                                    <option value="">=Pilih=</option>
                                    @foreach($dataProvinsi as $provinsi)
                                        <option value="{{base64_encode($provinsi->id)}}" @if(base64_encode($provinsi->id) == old('provinsi') ) SELECTED @endif>{{$provinsi->name}}</option>
                                    @endforeach
                                </select>
                                @error('provinsi')
                                <div class="text-sm text-danger errorMessage">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label for="kabupatenX" class="form-label">Kabupaten <span class="text-danger">*</span></label>
                                <select class="form-select" id="kabupatenX" name="kabupaten" >
                                    <option value="">=Pilih=</option>
                                </select>
                                @error('kabupaten')
                                <div class="text-sm text-danger errorMessage">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label for="kecamatanX" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                <select class="form-select" id="kecamatanX" name="kecamatan" >
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
                                          placeholder="Masukkan Detail Alamat" rows="3">{{old('address')}}</textarea>
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

    @push('customJS')
        <!-- ckeditor -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"
                integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            // ClassicEditor
            //     .create(document.querySelector('#editor'))
            //     .catch(error => {
            //         console.error(error);
            //     });


            $(document).ready(function() {
                let provinsi = $('#provinsiX');
                let kabupaten = $('#kabupatenX');
                let kecamatan = $('#kecamatanX');
                let formInput = $("form#formProperty :input");

                provinsi.select2();
                kabupaten.select2();
                kecamatan.select2();

                if(provinsi.val() != null){
                    getKabupaten(provinsi.val(),kabupaten,kecamatan)
                }

                formInput.on('keypress',function(){
                    makeValid();
                })

                function makeValid(){
                    let pesanError = $('.errorMessage');
                    pesanError.removeClass('text-danger');
                    pesanError.text("");
                    formInput.each(function(){
                        let input = $(this); // This is the jquery object of the input, do what you will
                        input.removeClass('is-invalid');
                    });
                }

                function getKabupaten(idProvinsi,kabupaten,kecamatan){
                    let kab = '{{route('agn.lists.kabupaten','id')}}';
                    let urlGetKabupaten = kab.replace('id', idProvinsi);
                    kabupaten.find('option').not(':first').remove();
                    kecamatan.find('option').not(':first').remove();
                    $.ajax({
                        url: urlGetKabupaten,
                        type: 'get',
                        dataType: 'json',
                        success: function (response) {
                            let len = 0;
                            if (response != null) {
                                len = response.length;
                            }
                            if (len > 0) {
                                for (let i = 0; i < len; i++) {
                                    let id = response[i].id;
                                    let name = response[i].name;
                                    let option = "<option value='" + id + "'>" + name + "</option>";
                                    kabupaten.append(option);
                                }
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            console.log(xhr.status);
                            console.log(thrownError);
                        }
                    });
                }
                provinsi.change(function () {
                    let idProvinsi = $(this).val();
                    getKabupaten(idProvinsi,kabupaten,kecamatan);
                    makeValid();
                });

                kabupaten.change(function () {
                    let idKabupaten = $(this).val();
                    let kec = '{{route('agn.lists.kecamatan','id')}}';
                    let urlGetKecamatan = kec.replace('id', idKabupaten);
                    kecamatan.find('option').not(':first').remove();
                    $.ajax({
                        url: urlGetKecamatan,
                        type: 'get',
                        dataType: 'json',
                        success: function (response) {
                            let len = 0;
                            if (response != null) {
                                len = response.length;
                            }
                            if (len > 0) {
                                for (let i = 0; i < len; i++) {
                                    let id = response[i].id;
                                    let name = response[i].name;
                                    let option = "<option value='" + id + "'>" + name + "</option>";
                                    kecamatan.append(option);
                                }
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            console.log(xhr.status);
                            console.log(thrownError);
                        }
                    });
                });
            });
        </script>
    @endpush
</x-agent.agent-template>
