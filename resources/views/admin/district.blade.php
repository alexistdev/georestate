<x-admin.admin-template>
    @push('customCSS')
        <x-admin.datatable-c-s-s/>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    @endpush
    <div class="row">
        @if ($message = Session::get('success'))
            <div class="col-lg-12">
                <div class="alert alert-success  alert-dismissible alert-outline fade show" role="alert">
                    <strong> Success ! </strong> - {!! $message !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if ($message = Session::get('delete'))
            <div class="col-lg-12">
                <div class="alert alert-danger  alert-dismissible alert-outline fade show" role="alert">
                    <strong> Delete ! </strong> - {!! $message !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif


        @if ($errors->any())
            <div class="col-lg-12">
                <div class="alert alert-danger  alert-dismissible alert-outline fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        <strong> Error ! </strong> - {{ $error }}
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>
    <div class="row">

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0 float-start">Data Provinsi</h5>
                    <button class="btn btn-sm btn-primary float-end" data-bs-toggle="modal"
                            data-bs-target="#tambahProvinsi"><i class="mdi mdi-book-plus-multiple align-middle m-1"></i>
                        Add
                    </button>
                </div>
                <div class="card-body">
                    <table id="tabelProvince"
                           class="table nowrap dt-responsive align-middle table-hover table-bordered"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0 float-start">Data Kabupaten</h5>
                    <button class="btn btn-sm btn-primary float-end" data-bs-toggle="modal"
                            data-bs-target="#tambahKabupaten"><i
                            class="mdi mdi-book-plus-multiple align-middle m-1"></i>
                        Add
                    </button>
                </div>
                <div class="card-body">

                    <table id="tabelKabupaten"
                           class="table nowrap dt-responsive align-middle table-hover table-bordered"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Provinsi</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{--        <div class="col-lg-4">--}}
        {{--            <div class="card">--}}
        {{--                <div class="card-header">--}}
        {{--                    <h5 class="card-title mb-0">Data Kecamatan</h5>--}}
        {{--                </div>--}}
        {{--                <div class="card-body">--}}
        {{--                    <table id="alternative-pagination"--}}
        {{--                           class="table nowrap dt-responsive align-middle table-hover table-bordered"--}}
        {{--                           style="width:100%">--}}
        {{--                        <thead>--}}
        {{--                        <tr>--}}
        {{--                            <th class="text-center">No.</th>--}}
        {{--                            <th class="text-center">Code</th>--}}
        {{--                            <th class="text-center">Nama</th>--}}
        {{--                            <th class="text-center">Action</th>--}}
        {{--                        </tr>--}}
        {{--                        </thead>--}}
        {{--                        <tbody>--}}

        {{--                        </tbody>--}}
        {{--                    </table>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>

    <!-- START: Modal TAMBAH PROVINSI-->
    <div class="modal fade" id="tambahProvinsi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('adm.disctrict.provinsi.save')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Provinsi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label
                                    for="provinsiName" @class(["form-label"]) >NAME</label>
                                <input type="text" name="name" maxlength="255"
                                       @class(["form-control"]) style="text-transform:uppercase"
                                       value="{{old('name')}}" placeholder="Masukkan Nama Provinsi"
                                       id="provinsiName" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal EDIT TAMBAH-->

    <!-- START: Modal EDIT PROVINSI-->
    <div class="modal fade" id="editProvinsi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('adm.disctrict.provinsi.update')}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Provinsi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="editProvinsiId" class="hidden"></label>
                                <input type="hidden" name="provinsi_id" class="form-control"
                                       value="{{old('provinsi_id')}}"
                                       id="editProvinsiId">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label
                                    for="editProvinsiName" @class(["form-label"]) >CODE</label>
                                <input type="text" name="name" maxlength="125"
                                       @class(["form-control"]) style="text-transform:uppercase"
                                       value="{{old('name')}}"
                                       id="editProvinsiName">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal EDIT PROVINSI-->

    <!-- START: Modal HAPUS PROVINSI-->
    <div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('adm.disctrict.provinsi.delete')}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Provinsi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <input type="hidden" name="provinsi_id" class="form-control"
                                       value="{{old('provinsi_id')}}"
                                       id="hapusProvinsiId">
                                Apa anda ingin menghapus data Provinsi ini?
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal HAPUS PROVINSI-->

    <!-- START: Modal TAMBAH KABUPATEN-->
    <div class="modal fade modalEditAll" id="tambahKabupaten" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('adm.disctrict.kabupaten.save')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Provinsi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="provinsiNamex">PROVINSI</label>
                                <select id="provinsiNamex" class="form-control" name="provinsi_id">
                                    @foreach($dataProvinsi as $prov)
                                        <option
                                            value="{{base64_encode($prov->id)}}">{{$prov->name." [".$prov->code ."] "}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label
                                    for="kabupatenCode" @class(["form-label"]) >CODE</label>
                                <input type="text" name="code" maxlength="125" placeholder="Masukkan Kode Kabupaten"
                                       style="text-transform:uppercase"
                                       @class(["form-control"]) value="{{old('code')}}"
                                       id="kabupatenCode" required>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label
                                    for="kabupatenName" @class(["form-label"]) >NAME</label>
                                <input type="text" name="name" maxlength="255"
                                       @class(["form-control"]) style="text-transform:uppercase"
                                       value="{{old('name')}}" placeholder="Masukkan Nama Kabupaten"
                                       id="kabupatenName" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal TAMBAH KABUPATEN-->

    <!-- START: Modal EDIT KABUPATEN-->
    <div class="modal fade modalEditAll" id="editKabupaten" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{route('adm.disctrict.kabupaten.update')}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">EDIT DATA KABUPATEN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" name="kabupaten_id" id="kabupaten_id"
                                       value="{{old('kabupaten_id')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="provinsiNamey">PROVINSI</label>
                                <select id="provinsiNamey" class="editSelectedProvinsi form-control" name="provinsi_id">
                                    @foreach($dataProvinsi as $prov)
                                        <option
                                            value="{{base64_encode($prov->id)}}">{{$prov->name." [".$prov->code ."] "}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label
                                    for="kabupatenCodeEdit" @class(["form-label"]) >CODE</label>
                                <input type="text" name="code" maxlength="125" placeholder="Masukkan Kode Kabupaten"
                                       style="text-transform:uppercase"
                                       @class(["form-control"]) value="{{old('code')}}"
                                       id="kabupatenCodeEdit" required>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label
                                    for="kabupatenNameEdit" @class(["form-label"]) >NAME</label>
                                <input type="text" name="name" maxlength="255"
                                       @class(["form-control"]) style="text-transform:uppercase"
                                       value="{{old('name')}}" placeholder="Masukkan Nama Kabupaten"
                                       id="kabupatenNameEdit" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modal EDIT KABUPATEN-->

        <!-- START: Modal HAPUS KABUPATEN-->
        <div class="modal fade" id="modalHapusKabupaten" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{route('adm.disctrict.kabupaten.delete')}}" method="post">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">HAPUS KABUPATEN</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <input type="hidden" name="kabupaten_id" class="form-control"
                                           value="{{old('kabupaten_id')}}"
                                           id="hapusKabupatenId">
                                    Apa anda ingin menghapus data Kabupaten ini?
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END: Modal HAPUS KABUPATEN-->


    @push('customJS')
        <x-admin.datatable-j-s/>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            let provinceURL = "{{route('adm.ajax.provinsi')}}";
            let kabupatenURL = "{{route('adm.ajax.kabupaten')}}";

            /** saat tombol edit provinsi di klik */
            $(document).on("click", ".open-edit-provinsi", function (e) {
                e.preventDefault();
                let fid = $(this).data('id');
                let fname = $(this).data('name');
                $('#editProvinsiId').val(fid);
                $('#editProvinsiName').val(fname);
            })

            /** saat tombol hapus provinsi di klik */
            $(document).on("click", ".open-hapus-provinsi", function (e) {
                e.preventDefault();
                let fid = $(this).data('id');
                $('#hapusProvinsiId').val(fid);
            })

            /** saat tombol edit kabupaten di klik */
            $(document).on("click", ".open-edit-kabupaten", function (e) {
                e.preventDefault();
                let fid = $(this).data('id');
                let fprov = $(this).data('provinsi');
                let fcode = $(this).data('code');
                let fname = $(this).data('name');
                $('#provinsiNamey').val(fprov).change();
                $('#kabupatenCodeEdit').val(fcode);
                $('#kabupatenNameEdit').val(fname);
                $('#kabupaten_id').val(fid);
            })

            /** saat tombol hapus provinsi di klik */
            $(document).on("click", ".open-hapus-kabupaten", function (e) {
                e.preventDefault();
                let fid = $(this).data('id');
                $('#hapusKabupatenId').val(fid);
            })


            document.addEventListener("DOMContentLoaded", function () {
                new DataTable("#tabelProvince", {
                    pagingType: "full_numbers",
                    ajax: {
                        type: 'GET',
                        url: provinceURL,
                        async: true,
                    },
                    language: {
                        processing: "Loading",
                    },
                    columns: [
                        {
                            data: 'index',
                            class: 'text-center',
                            defaultContent: '',
                            orderable: false,
                            searchable: false,
                            width: '5%',
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1; //auto increment
                            }
                        },
                        {data: 'name', class: 'text-center'},
                        {data: 'action', class: 'text-center', orderable: false},
                    ],
                    "bDestroy": true
                })
            });

            document.addEventListener("DOMContentLoaded", function () {
                new DataTable("#tabelKabupaten", {
                    pagingType: "full_numbers",
                    ajax: {
                        type: 'GET',
                        url: kabupatenURL,
                        async: true,
                    },
                    language: {
                        processing: "Loading",
                    },
                    columns: [
                        {
                            data: 'index',
                            class: 'text-center',
                            defaultContent: '',
                            orderable: false,
                            searchable: false,
                            width: '5%',
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1; //auto increment
                            }
                        },
                        {data: 'code', class: 'text-center'},
                        {data: 'name', class: 'text-center'},
                        {data: 'provinsi', class: 'text-center'},
                        {data: 'action', class: 'text-center', orderable: false},
                    ],
                    "bDestroy": true
                })
            });
            $(document).ready(function () {
                $('#provinsiNamex').select2({
                    dropdownParent: $("#tambahKabupaten")
                });
                $('#provinsiNamey').select2({
                    dropdownParent: $("#editKabupaten")
                });
            });
        </script>
    @endpush
</x-admin.admin-template>
