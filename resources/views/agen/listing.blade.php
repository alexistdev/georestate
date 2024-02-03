<x-agent.agent-template :title="$title" :menu-utama="$menuUtama" :menu-kedua="$menuKedua">

    @push('customCSS')
        <!--datatable css-->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
        <!--datatable responsive css-->
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>

        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
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

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <a href="{{route('agn.lists.add')}}">
                                <button class="btn btn-info add-btn"><i class="ri-add-fill me-1 align-bottom"></i> Add
                                    Property
                                </button>
                            </a>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="hstack text-nowrap gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                        class="ri-delete-bin-2-line"></i></button>
                                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addmembers"><i
                                        class="ri-filter-2-line me-1 align-bottom"></i> Filters
                                </button>
                                <button class="btn btn-soft-success">Import</button>
                                <button type="button" id="dropdownMenuLink1" data-bs-toggle="dropdown"
                                        aria-expanded="false" class="btn btn-soft-info"><i class="ri-more-2-fill"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                    <li><a class="dropdown-item" href="#">All</a></li>
                                    <li><a class="dropdown-item" href="#">Last Week</a></li>
                                    <li><a class="dropdown-item" href="#">Last Month</a></li>
                                    <li><a class="dropdown-item" href="#">Last Year</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col-xxl-12">
            <div class="card" id="myListing">
                <div class="card-header">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <div class="search-box">
                                <input type="text" class="form-control search" placeholder="Search for company...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-md-auto ms-auto">
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted">Sort by: </span>
                                <select class="form-control mb-0" data-choices data-choices-search-false
                                        id="choices-single-default">
                                    <option value="Owner">Owner</option>
                                    <option value="Company">Company</option>
                                    <option value="location">Location</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mt-3 mb-1">
                        <table class="table align-middle table-nowrap">
                            <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 50px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>
                                <th class="sort text-center" data-sort="name" scope="col">Nama Property</th>
                                <th class="sort text-center" data-sort="owner" scope="col">Harga Sewa / Bulan</th>
                                <th class="sort text-center" data-sort="industry_type" scope="col">Kategori</th>
                                <th class="sort text-center" data-sort="star_value" scope="col">Rating</th>
                                <th class="sort text-center" data-sort="location" scope="col">Lokasi</th>
                                <th class="sort text-center" data-sort="location" scope="col">Premium</th>
                                <th class="sort text-center" data-sort="location" scope="col">Status</th>
                                <th class="sort text-center" data-sort="location" scope="col">Created</th>
                                <th class="text-center" scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody class="list form-check-all">
                            @foreach($dataList as $list)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                   value="option1">
                                        </div>
                                    </th>
                                    <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                                            class="fw-medium link-primary">#VZ001</a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 ms-2 name">{{$list->name ?? ""}}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price">{{$list->price ?? 0}}</td>
                                    <td class="category">{{$list->kategori->name ?? ""}}</td>
                                    <td class="text-center"><span class="text-center">4.5</span> <i
                                            class="ri-star-fill text-warning align-bottom"></i></td>

                                    <td class="location">{{$list->kecamatan->name ?? ""}}
                                        , {{$list->kecamatan->kabupaten->provinsi->name ?? ""}}</td>
                                    <td>
                                        @if($list->isPremium)
                                            <span class="badge bg-success">Premium </span>
                                        @else
                                            <span class="badge bg-dark">Free </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($list->isStatus == 0)
                                            <span class="badge bg-warning">Pending Review </span>
                                        @elseif($list->isStatus == 1)
                                            <span class="badge bg-success">Active </span>
                                        @elseif($list->isStatus == 2)
                                            <span class="badge bg-primary">Non Active </span>
                                        @else
                                            <span class="badge bg-danger">Void </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{date("d-m-Y H:i:s", strtotime($list->created_at))}}
                                    </td>
                                    <td class="text-end">
                                        <div class="list-inline hstack gap-2 justify-content-center">
                                            <a href="javascript:void(0);" class="text-muted d-inline-block">
                                                <i class="ri-phone-line fs-16"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="text-muted d-inline-block">
                                                <i class="ri-question-answer-line fs-16"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="view-item-btn"><i
                                                    class="ri-eye-fill align-bottom text-muted"></i></a>
                                            <a class="edit-item-btn" href="#showModal" data-bs-toggle="modal"><i
                                                    class="ri-pencil-fill align-bottom text-muted"></i></a>
                                            <a class="remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
                                                <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                </lord-icon>
                                <h5 class="mt-2">Maaf! Data tidak ditemukan!</h5>
                                <p class="text-muted mb-0">.</p>
                            </div>
                        </div>
                    </div>
                    <!--end add modal-->

                    <div class="mt-3">
                        <div class="agination-wrap hstack gap-2 d-flex justify-content-start">
                            Total data : {{$dataList->count()}} / {{$dataList->total()}}
                        </div>
                        <div class="pagination-wrap hstack gap-2 d-flex justify-content-end">
                            @if($dataList->onFirstPage())
                                <a class="page-item pagination-prev disabled"
                                   href="#">
                                    First
                                </a>
                            @else
                                <a class="page-item pagination-prev"
                                   href="{{$dataList->url("1")}}">
                                    First
                                </a>
                            @endif
                            <ul class="pagination listjs-pagination mb-0">{{$dataList->appends(Request::except('page'))->links()}}</ul>
                            @if($dataList->hasMorePages() == "1")
                                <a class="page-item pagination-next" href="{{$dataList->url($dataList->lastPage())}}">
                                    Last
                                </a>
                            @else
                                <a class="page-item pagination-next disabled" href="#">
                                    Last
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <!--end card-->
        </div>
        <!--end col-->

        <!--end col-->
    </div>

    @push('customJS')
        <script src="{{asset('template/admin/assets/libs/list.js/list.min.js')}}"></script>
        <script>
            let options = {
                valueNames: ['name', 'price', 'category', 'location']
            };

            let userList = new List('myListing', options);

            document.getElementById("myListing") && (customerList = new List("myListing", options).on("updated", function(e) {
                0 === e.matchingItems.length ? document.getElementsByClassName("noresult")[0].style.display = "block" : document.getElementsByClassName("noresult")[0].style.display = "none";
                let t = 1 === e.i,
                    a = e.i > e.matchingItems.length - e.page;
                document.querySelector(".pagination-prev.disabled") && document.querySelector(".pagination-prev.disabled").classList.remove("disabled"), document.querySelector(".pagination-next.disabled") && document.querySelector(".pagination-next.disabled").classList.remove("disabled"), t && document.querySelector(".pagination-prev").classList.add("disabled"), a && document.querySelector(".pagination-next").classList.add("disabled"), e.matchingItems.length <= perPage ? document.querySelector(".pagination-wrap").style.display = "none" : document.querySelector(".pagination-wrap").style.display = "flex", e.matchingItems.length === perPage && document.querySelector(".pagination.listjs-pagination").firstElementChild.children[0].click(), 0 < e.matchingItems.length ? document.getElementsByClassName("noresult")[0].style.display = "none" : document.getElementsByClassName("noresult")[0].style.display = "block"
            }));
        </script>
    @endpush
</x-agent.agent-template>
