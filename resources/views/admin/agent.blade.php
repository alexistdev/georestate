<x-admin.admin-template>
    @push('customCSS')
        <x-admin.datatable-c-s-s />
    @endpush
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Data Agen Property</h5>
                </div>
                <div class="card-body">
                    <table id="alternative-pagination"
                           class="table nowrap dt-responsive align-middle table-hover table-bordered"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Agen ID</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Jenis Akun</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">Kecamatan</th>
                            <th class="text-center">Tanggal Bergabung</th>
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
        <!-- START: Modal DETAIL KECAMATAN-->
        <div class="modal fade" id="modalKecamatan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">DETAIL KECAMATAN <span class="text-success" id="kecx"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <tr>
                                            <td>KABUPATEN</td>
                                            <td> : </td>
                                            <td><span id="kabx"></span></td>
                                        </tr>
                                        <tr>
                                            <td>PROVINSI</td>
                                            <td> : </td>
                                            <td><span id="provx"></span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <!-- END: Modal DETAIL KECAMATAN-->
    @push('customJS')
        <x-admin.datatable-j-s />
        <script>
            let base_url = "{{route('adm.agent')}}";

            /** saat tombol kecamatan di klik */
            $(document).on("click", ".open-kecamatan", function (e) {
                e.preventDefault();
                let fkab = $(this).data('kabupaten');
                let fprov = $(this).data('provinsi');
                let fkec = $(this).data('kecamatan');
                $('#kabx').text(fkab);
                $('#provx').text(fprov);
                $('#kecx').text(fkec);
            })

            document.addEventListener("DOMContentLoaded", function() {
                new DataTable("#alternative-pagination", {
                    pagingType: "full_numbers",
                    ajax: {
                        type: 'GET',
                        url: base_url,
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
                        {data: 'agentID', class: 'text-center'},
                        {data: 'name', class: 'text-center'},
                        {data: 'email', class: 'text-center'},
                        {data: 'isPremium', class: 'text-center'},
                        {data: 'phone', class: 'text-center'},
                        {data: 'alamat', class: 'text-center'},
                        {data: 'kecamatan', class: 'text-center'},
                        {data: 'created_at', class: 'text-center'},
                        {data: 'action', class: 'text-center', orderable: false},
                    ],
                    "bDestroy": true

                })
            });
        </script>
    @endpush
</x-admin.admin-template>
