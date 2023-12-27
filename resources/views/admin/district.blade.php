<x-admin.admin-template>
    @push('customCSS')
        <x-admin.datatable-c-s-s/>
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
                            <th class="text-center">Code</th>
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
                    <h5 class="card-title mb-0">Data Kabupaten</h5>
                </div>
                <div class="card-body">

                    <table id="alternative-pagination"
                           class="table nowrap dt-responsive align-middle table-hover table-bordered"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Code</th>
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
                                    for="provinsiCode" @class(["form-label"]) >CODE</label>
                                <input type="text" name="code" maxlength="125" placeholder="Masukkan Kode Provinsi"
                                       style="text-transform:uppercase"
                                       @class(["form-control"]) value="{{old('code')}}"
                                       id="provinsiCode" required>
                            </div>
                        </div>

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
                                    for="editProvinsiCode" @class(["form-label"]) >CODE</label>
                                <input type="text" name="code" maxlength="125"
                                       @class(["form-control"]) value="{{old('code')}}"
                                       id="editProvinsiCode">
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
    <!-- END: Modal HAPUS TAMBAH-->

    <!-- START: Modal EDIT KABUPATEN-->
    <div class="modal fade" id="editProvinsi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Modal EDIT KABUPATEN-->
    @push('customJS')
        <x-admin.datatable-j-s/>
        <script>
            let provinceURL = "{{route('adm.ajax.provinsi')}}";


            /** saat tombol edit provinsi di klik */
            $(document).on("click", ".open-edit-provinsi", function (e) {
                e.preventDefault();
                let fid = $(this).data('id');

                let fcode = $(this).data('code');
                let fname = $(this).data('name');
                $('#editProvinsiCode').val(fcode);
                $('#editProvinsiId').val(fid);
                $('#editProvinsiName').val(fname);
            })

            /** saat tombol hapus provinsi di klik */
            $(document).on("click", ".open-hapus-provinsi", function (e) {
                e.preventDefault();
                let fid = $(this).data('id');
                $('#hapusProvinsiId').val(fid);
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
                        {data: 'code', class: 'text-center'},
                        {data: 'name', class: 'text-center'},
                        // {data: 'email', class: 'text-center'},
                        // {data: 'isPremium', class: 'text-center'},
                        // {data: 'phone', class: 'text-center'},
                        // {data: 'alamat', class: 'text-center'},
                        // {data: 'created_at', class: 'text-center'},
                        {data: 'action', class: 'text-center', orderable: false},
                    ],
                    "bDestroy": true

                })
            });
        </script>
    @endpush
</x-admin.admin-template>
