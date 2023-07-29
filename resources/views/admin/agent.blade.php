<x-admin.admin-template>
    @push('customCSS')
        <x-admin.datatable-c-s-s />
    @endpush
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Alternative Pagination</h5>
                </div>
                <div class="card-body">
                    <table id="alternative-pagination"
                           class="table nowrap dt-responsive align-middle table-hover table-bordered"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Jenis Akun</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Alamat</th>
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

    @push('customJS')
        <x-admin.datatable-j-s />
        <script>
            let base_url = "{{route('adm.agent')}}";
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
                        {data: 'name', class: 'text-center'},
                        {data: 'email', class: 'text-center'},
                        {data: 'isPremium', class: 'text-center'},
                        {data: 'phone', class: 'text-center'},
                        // {data: 'created_at', class: 'text-center'},
                        // {data: 'action', class: 'text-center', orderable: false},
                    ],
                    "bDestroy": true

                })
            });
        </script>
    @endpush
</x-admin.admin-template>
