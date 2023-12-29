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

        <div class="col-lg-4 d-flex align-items-stretch">
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
                           class="table table-sm nowrap dt-responsive align-middle table-hover table-bordered"
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
        <div class="col-lg-4 d-flex align-items-stretch">
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
                           class="table table-sm nowrap dt-responsive align-middle table-hover table-bordered"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">No.</th>
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
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0 float-start">Data Kecamatan</h5>
                    <button class="btn btn-sm btn-primary float-end" data-bs-toggle="modal"
                            data-bs-target="#tambahKecamatan"><i
                            class="mdi mdi-book-plus-multiple align-middle m-1"></i>
                        Add
                    </button>
                </div>
                <div class="card-body">
                    <table id="tabelKecamatan"
                           class="table nowrap dt-responsive align-middle table-hover table-bordered"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Kabupaten</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-admin.modal.district-modal :data-provinsi="$dataProvinsi" :data-kabupaten="$dataKabupaten"/>

    @push('customJS')
        <x-admin.datatable-j-s/>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            let provinceURL = "{{route('adm.ajax.provinsi')}}";
            let kabupatenURL = "{{route('adm.ajax.kabupaten')}}";
            let kecamatanURL = "{{route('adm.ajax.kecamatan')}}";

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
                let fname = $(this).data('name');
                $('#provinsiNamey').val(fprov).change();
                $('#kabupatenNameEdit').val(fname);
                $('#kabupaten_id').val(fid);
            })

            /** saat tombol hapus provinsi di klik */
            $(document).on("click", ".open-hapus-kabupaten", function (e) {
                e.preventDefault();
                let fid = $(this).data('id');
                $('#hapusKabupatenId').val(fid);
            })

            /** saat tombol edit kecamatan di klik */
            $(document).on("click", ".open-edit-kecamatan", function (e) {
                e.preventDefault();
                let fid = $(this).data('id');
                let fkab = $(this).data('kabupaten');
                let fname = $(this).data('name');
                $('#kabupatenNamey').val(fkab).change();
                $('#kecamatanNameEdit').val(fname);
                $('#kecamatan_id').val(fid);
            })

            /** saat tombol hapus provinsi di klik */
            $(document).on("click", ".open-hapus-kecamatan", function (e) {
                e.preventDefault();
                let fid = $(this).data('id');
                $('#hapusKecamatanId').val(fid);
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
                        {data: 'name', class: 'text-center'},
                        {data: 'provinsi', class: 'text-center'},
                        {data: 'action', class: 'text-center', orderable: false},
                    ],
                    "bDestroy": true
                })
            });

            document.addEventListener("DOMContentLoaded", function () {
                new DataTable("#tabelKecamatan", {
                    pagingType: "full_numbers",
                    ajax: {
                        type: 'GET',
                        url: kecamatanURL,
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
                        {data: 'kabupaten', class: 'text-center'},
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

                $('#kecamatanNameX').select2({
                    dropdownParent: $("#tambahKecamatan")
                });

                $('#kabupatenNamey').select2({
                    dropdownParent: $("#editKecamatan")
                });
            });
        </script>
    @endpush
</x-admin.admin-template>
