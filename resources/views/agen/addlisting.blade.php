<x-agent.agent-template :title="$title" :menu-utama="$menuUtama" :menu-kedua="$menuKedua">

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

    <form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="product-title-input">Listing Title</label>
                            <input type="text" class="form-control" id="product-title-input" value=""
                                   placeholder="Enter product title" required>
                        </div>
                        <div>
                            <label>Deskripsi</label>
                            <div id="editor">
                                <textarea class="form-control" id="detail_alamat" name="address"
                                          placeholder="Enter meta address" rows="3"></textarea>
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
                                    General Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#addproduct-metadata" role="tab">
                                    Meta Data
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- end card header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="addproduct-general-info" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturer-name-input">Manufacturer
                                                Name</label>
                                            <input type="text" class="form-control" id="manufacturer-name-input"
                                                   placeholder="Enter manufacturer name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturer-brand-input">Manufacturer
                                                Brand</label>
                                            <input type="text" class="form-control" id="manufacturer-brand-input"
                                                   placeholder="Enter manufacturer brand">
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="stocks-input">Luas Tanah /Panjang Ruangan</label>
                                            <input type="text" class="form-control" id="stocks-input"
                                                   placeholder="Stocks" required>
                                            <div class="invalid-feedback">Please Enter a product stocks.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="product-price-input">Luas Bangunan / Lebar Ruangan</label>
                                            <input type="text" class="form-control" id="stocks-input"
                                                   placeholder="Stocks" required>

                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="product-discount-input">Harga Sewa / Bulan</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="product-discount-addon">Rp</span>
                                                <input type="text" class="form-control" id="product-discount-input"
                                                       placeholder="Enter discount" aria-label="discount"
                                                       aria-describedby="product-discount-addon">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="orders-input">Orders</label>
                                            <input type="text" class="form-control" id="orders-input"
                                                   placeholder="Orders" required>
                                            <div class="invalid-feedback">Please Enter a product orders.</div>
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
                                            <label class="form-label" for="meta-title-input">Meta title</label>
                                            <input type="text" class="form-control" placeholder="Enter meta title"
                                                   id="meta-title-input">
                                        </div>
                                    </div>
                                    <!-- end col -->

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta-keywords-input">Meta Keywords</label>
                                            <input type="text" class="form-control" placeholder="Enter meta keywords"
                                                   id="meta-keywords-input">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div>
                                    <label class="form-label" for="meta-description-input">Meta Description</label>
                                    <textarea class="form-control" id="meta-description-input"
                                              placeholder="Enter meta description" rows="3"></textarea>
                                </div>
                            </div>
                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->
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
                        <h5 class="card-title mb-0">Address</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="provinsi_id" class="form-label">Provinsi</label>
                                <select class="form-select" id="provinsi_id" name="provinsi">
                                    <option value="">=Pilih=</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label for="kabupaten_id" class="form-label">Kabupaten</label>
                                <select class="form-select" id="kabupaten_id" name="kabupaten">
                                    <option value="">=Pilih=</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label for="kecamatan_id" class="form-label">Kecamatan</label>
                                <select class="form-select" id="kecamatan_id" name="kecamatan">
                                    <option value="">=Pilih=</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label class="form-label" for="detail_alamat">Detail Alamat</label>
                                <textarea class="form-control" id="detail_alamat"
                                          placeholder="Enter meta address" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Kategori</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-select" id="choices-category-input" name="choices-category-input"
                                data-choices data-choices-search-false>
                            <option value="Appliances">Appliances</option>
                            <option value="Automotive Accessories">Automotive Accessories</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Furniture">Furniture</option>
                            <option value="Grocery">Grocery</option>
                            <option value="Kids">Kids</option>
                            <option value="Watches">Watches</option>
                        </select>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->


                <!-- end card -->

            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </form>

    @push('customJS')
        <!-- ckeditor -->
        <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .catch( error => {
                    console.error( error );
                } );
        </script>
    @endpush
</x-agent.agent-template>
