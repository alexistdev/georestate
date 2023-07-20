<x-front.front-end-template :title="$judul" :main-label="$menuUtama" :secondary-label="$menuKedua">
    <section class="page-header page-header-modern bg-color-primary border-0 m-0">
        <div class="container position-relative z-index-2">
            <div class="row text-center text-md-start py-5">
                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="font-weight-bold text-color-light text-8 mb-0">Properties</h1>
                    <p class="text-color-light opacity-7 mb-0">Sed consequat euismod diam, eu ultrices nulla ullamcorper ac</p>
                </div>
                <div class="col-md-4 order-1 order-md-2 align-self-center">
                    <ul class="breadcrumb breadcrumb-light d-block text-md-end text-4 mb-0">
                        <li><a href="#" class="text-decoration-none">Home</a></li>
                        <li class="text-upeercase active">Properties</li>
                    </ul>
                </div>
            </div>
        </div>

        <form class="form-style-3 pb-5" id="propertiesForm" action="demo-real-estate-properties.html" method="POST">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 mb-2 mb-lg-0">
                        <select class="form-select form-control text-default box-shadow-none" name="propertiesPropertyType" data-msg-required="This field is required." id="propertiesPropertyType" required="">
                            <option value="">Property Type</option>
                            <option value="1">Apartment</option>
                            <option value="2">House</option>
                        </select>
                    </div>
                    <div class="col-lg-2 mb-2 mb-lg-0">
                        <select class="form-select form-control text-default box-shadow-none" name="propertiesLocation" data-msg-required="This field is required." id="propertiesLocation" required="">
                            <option value="">Location</option>
                            <option value="1">Miami</option>
                            <option value="2">New York</option>
                            <option value="3">Houston</option>
                            <option value="4">Los Angeles</option>
                        </select>
                    </div>
                    <div class="col-lg-2 mb-2 mb-lg-0">
                        <select class="form-select form-control text-default box-shadow-none" name="propertiesMinBeds" data-msg-required="This field is required." id="propertiesMinBeds" required="">
                            <option value="">Min Beds</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="col-lg-2 mb-2 mb-lg-0">
                        <select class="form-select form-control text-default box-shadow-none" name="propertiesMinPrice" data-msg-required="This field is required." id="propertiesMinPrice" required="">
                            <option value="">Min Price</option>
                            <option value="150000">$150,000</option>
                            <option value="200000">$200,000</option>
                            <option value="250000">$250,000</option>
                            <option value="300000">$300,000</option>
                            <option value="350000">$350,000</option>
                            <option value="400000">$400,000</option>
                            <option value="450000">$450,000</option>
                            <option value="500000">$500,000</option>
                            <option value="550000">$550,000</option>
                            <option value="600000">$600,000</option>
                            <option value="650000">$650,000</option>
                            <option value="700000">$700,000</option>
                            <option value="750000">$750,000</option>
                            <option value="800000">$800,000</option>
                            <option value="850000">$850,000</option>
                            <option value="900000">$900,000</option>
                            <option value="950000">$950,000</option>
                            <option value="1000000">$1,000,000</option>
                            <option value="1250000">$1,250,000</option>
                            <option value="1500000">$1,500,000</option>
                            <option value="1750000">$1,750,000</option>
                            <option value="2000000">$2,000,000</option>
                            <option value="2250000">$2,250,000</option>
                            <option value="2500000">$2,500,000</option>
                            <option value="2750000">$2,750,000</option>
                            <option value="3000000">$3,000,000</option>
                            <option value="3250000">$3,250,000</option>
                            <option value="3500000">$3,500,000</option>
                            <option value="3750000">$3,750,000</option>
                            <option value="4000000">$4,000,000</option>
                            <option value="4250000">$4,250,000</option>
                            <option value="4500000">$4,500,000</option>
                            <option value="4750000">$4,750,000</option>
                            <option value="5000000">$5,000,000</option>
                            <option value="6000000">$6,000,000</option>
                            <option value="7000000">$7,000,000</option>
                            <option value="8000000">$8,000,000</option>
                            <option value="9000000">$9,000,000</option>
                            <option value="10000000">$10,000,000</option>
                        </select>
                    </div>
                    <div class="col-lg-2 mb-2 mb-lg-0">
                        <select class="form-select form-control text-default box-shadow-none" name="propertiesMaxPrice" data-msg-required="This field is required." id="propertiesMaxPrice" required="">
                            <option value="">Max Price</option>
                            <option value="150000">$150,000</option>
                            <option value="200000">$200,000</option>
                            <option value="250000">$250,000</option>
                            <option value="300000">$300,000</option>
                            <option value="350000">$350,000</option>
                            <option value="400000">$400,000</option>
                            <option value="450000">$450,000</option>
                            <option value="500000">$500,000</option>
                            <option value="550000">$550,000</option>
                            <option value="600000">$600,000</option>
                            <option value="650000">$650,000</option>
                            <option value="700000">$700,000</option>
                            <option value="750000">$750,000</option>
                            <option value="800000">$800,000</option>
                            <option value="850000">$850,000</option>
                            <option value="900000">$900,000</option>
                            <option value="950000">$950,000</option>
                            <option value="1000000">$1,000,000</option>
                            <option value="1250000">$1,250,000</option>
                            <option value="1500000">$1,500,000</option>
                            <option value="1750000">$1,750,000</option>
                            <option value="2000000">$2,000,000</option>
                            <option value="2250000">$2,250,000</option>
                            <option value="2500000">$2,500,000</option>
                            <option value="2750000">$2,750,000</option>
                            <option value="3000000">$3,000,000</option>
                            <option value="3250000">$3,250,000</option>
                            <option value="3500000">$3,500,000</option>
                            <option value="3750000">$3,750,000</option>
                            <option value="4000000">$4,000,000</option>
                            <option value="4250000">$4,250,000</option>
                            <option value="4500000">$4,500,000</option>
                            <option value="4750000">$4,750,000</option>
                            <option value="5000000">$5,000,000</option>
                            <option value="6000000">$6,000,000</option>
                            <option value="7000000">$7,000,000</option>
                            <option value="8000000">$8,000,000</option>
                            <option value="9000000">$9,000,000</option>
                            <option value="10000000">$10,000,000</option>
                        </select>
                    </div>
                    <div class="col-lg-2 mb-2 mb-lg-0">
                        <div class="d-grid gap-2">
                            <input type="submit" value="Search Now" class="btn btn-secondary custom-btn-search-page-header font-weight-semibold border-0 text-1 text-uppercase mt-1 btn-px-4 btn-py-2">
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </section>

    <div class="container py-5 my-3">
        <div class="row">
            <div class="col">

                <h2 class="mb-4">Listing for <span class="text-color-secondary">Sale</span> or <span class="text-color-secondary">Rent</span></h2>

                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3 pb-4 mb-1">
                        <div class="card custom-card-info custom-card-info-shadow border-0">
                            <div class="card-body overflow-hidden p-relative z-index-1">
                                <a href="demo-real-estate-properties-detail.html" class="text-decoration-none">
                                    <span class="custom-card-info-type bg-primary text-color-light px-3 py-1 text-1 font-weight-semibold text-uppercase d-inline-block p-absolute top-8 left-8">For Sale</span>
                                    <span class="custom-card-info-img d-block">
													<img src="{{asset('template/frontend/img/demos/real-estate/listing/listing-1-thumb.jpg')}}" class="img-fluid">
												</span>
                                    <span class="custom-card-info-header d-block p-relative">
													<strong class="text-dark text-4">$ 1.250.000</strong>
													<img width="27" height="27" src="{{asset('template/frontend/img/demos/real-estate/icons/arrow-right.svg')}}" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-secondary custom-card-info-arrow p-absolute top-5 mt-2 me-3'}" />
												</span>
                                    <span class="custom-card-info-content d-block">
													<h4 class="text-dark mb-1 text-5">South Miami</h4>
													<ul class="list list-unstyled list-inline mb-0">
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Beds: 3</strong>
														</li>
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Baths: 2</strong>
														</li>
														<li class="list-inline-item me-0 mb-0">
															<strong class="text-default text-uppercase text-3">Sq Ft: 500</strong>
														</li>
													</ul>
												</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 pb-4 mb-1">
                        <div class="card custom-card-info custom-card-info-shadow border-0">
                            <div class="card-body overflow-hidden p-relative z-index-1">
                                <a href="demo-real-estate-properties-detail.html" class="text-decoration-none">
                                    <span class="custom-card-info-type bg-primary text-color-light px-3 py-1 text-1 font-weight-semibold text-uppercase d-inline-block p-absolute top-8 left-8">For Sale</span>
                                    <span class="custom-card-info-img d-block">
													<img src="{{asset('template/frontend/img/demos/real-estate/listing/listing-2-thumb.jpg')}}" class="img-fluid">
												</span>
                                    <span class="custom-card-info-header d-block p-relative">
													<strong class="text-dark text-4">$ 1.250.000</strong>
													<img width="27" height="27" src="{{asset('template/frontend/img/demos/real-estate/icons/arrow-right.svg')}}" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-secondary custom-card-info-arrow p-absolute top-5 mt-2 me-3'}" />
												</span>
                                    <span class="custom-card-info-content d-block">
													<h4 class="text-dark mb-1 text-5">South Miami</h4>
													<ul class="list list-unstyled list-inline mb-0">
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Beds: 3</strong>
														</li>
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Baths: 2</strong>
														</li>
														<li class="list-inline-item me-0 mb-0">
															<strong class="text-default text-uppercase text-3">Sq Ft: 500</strong>
														</li>
													</ul>
												</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 pb-4 mb-1">
                        <div class="card custom-card-info custom-card-info-shadow border-0">
                            <div class="card-body overflow-hidden p-relative z-index-1">
                                <a href="demo-real-estate-properties-detail.html" class="text-decoration-none">
                                    <span class="custom-card-info-type bg-primary text-color-light px-3 py-1 text-1 font-weight-semibold text-uppercase d-inline-block p-absolute top-8 left-8">For Sale</span>
                                    <span class="custom-card-info-img d-block">
													<img src="{{asset('template/frontend/img/demos/real-estate/listing/listing-3-thumb.jpg')}}" class="img-fluid">
												</span>
                                    <span class="custom-card-info-header d-block p-relative">
													<strong class="text-dark text-4">$ 1.250.000</strong>
													<img width="27" height="27" src="{{asset('template/frontend/img/demos/real-estate/icons/arrow-right.svg')}}" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-secondary custom-card-info-arrow p-absolute top-5 mt-2 me-3'}" />
												</span>
                                    <span class="custom-card-info-content d-block">
													<h4 class="text-dark mb-1 text-5">South Miami</h4>
													<ul class="list list-unstyled list-inline mb-0">
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Beds: 3</strong>
														</li>
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Baths: 2</strong>
														</li>
														<li class="list-inline-item me-0 mb-0">
															<strong class="text-default text-uppercase text-3">Sq Ft: 500</strong>
														</li>
													</ul>
												</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 pb-4 mb-1">
                        <div class="card custom-card-info custom-card-info-shadow border-0">
                            <div class="card-body overflow-hidden p-relative z-index-1">
                                <a href="demo-real-estate-properties-detail.html" class="text-decoration-none">
                                    <span class="custom-card-info-type bg-primary text-color-light px-3 py-1 text-1 font-weight-semibold text-uppercase d-inline-block p-absolute top-8 left-8">For Sale</span>
                                    <span class="custom-card-info-img d-block">
													<img src="{{asset('template/frontend/img/demos/real-estate/listing/listing-4-thumb.jpg')}}" class="img-fluid">
												</span>
                                    <span class="custom-card-info-header d-block p-relative">
													<strong class="text-dark text-4">$ 1.250.000</strong>
													<img width="27" height="27" src="{{asset('template/frontend/img/demos/real-estate/icons/arrow-right.svg')}}" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-secondary custom-card-info-arrow p-absolute top-5 mt-2 me-3'}" />
												</span>
                                    <span class="custom-card-info-content d-block">
													<h4 class="text-dark mb-1 text-5">South Miami</h4>
													<ul class="list list-unstyled list-inline mb-0">
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Beds: 3</strong>
														</li>
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Baths: 2</strong>
														</li>
														<li class="list-inline-item me-0 mb-0">
															<strong class="text-default text-uppercase text-3">Sq Ft: 500</strong>
														</li>
													</ul>
												</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 pb-4 mb-1">
                        <div class="card custom-card-info custom-card-info-shadow border-0">
                            <div class="card-body overflow-hidden p-relative z-index-1">
                                <a href="demo-real-estate-properties-detail.html" class="text-decoration-none">
                                    <span class="custom-card-info-type bg-primary text-color-light px-3 py-1 text-1 font-weight-semibold text-uppercase d-inline-block p-absolute top-8 left-8">For Sale</span>
                                    <span class="custom-card-info-img d-block">
													<img src="{{asset('template/frontend/img/demos/real-estate/listing/listing-5-thumb.jpg')}}" class="img-fluid">
												</span>
                                    <span class="custom-card-info-header d-block p-relative">
													<strong class="text-dark text-4">$ 1.250.000</strong>
													<img width="27" height="27" src="{{asset('template/frontend/img/demos/real-estate/icons/arrow-right.svg')}}" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-secondary custom-card-info-arrow p-absolute top-5 mt-2 me-3'}" />
												</span>
                                    <span class="custom-card-info-content d-block">
													<h4 class="text-dark mb-1 text-5">South Miami</h4>
													<ul class="list list-unstyled list-inline mb-0">
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Beds: 3</strong>
														</li>
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Baths: 2</strong>
														</li>
														<li class="list-inline-item me-0 mb-0">
															<strong class="text-default text-uppercase text-3">Sq Ft: 500</strong>
														</li>
													</ul>
												</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 pb-4 mb-1">
                        <div class="card custom-card-info custom-card-info-shadow border-0">
                            <div class="card-body overflow-hidden p-relative z-index-1">
                                <a href="demo-real-estate-properties-detail.html" class="text-decoration-none">
                                    <span class="custom-card-info-type bg-primary text-color-light px-3 py-1 text-1 font-weight-semibold text-uppercase d-inline-block p-absolute top-8 left-8">For Sale</span>
                                    <span class="custom-card-info-img d-block">
													<img src="{{asset('template/frontend/img/demos/real-estate/listing/listing-6-thumb.jpg')}}" class="img-fluid">
												</span>
                                    <span class="custom-card-info-header d-block p-relative">
													<strong class="text-dark text-4">$ 1.250.000</strong>
													<img width="27" height="27" src="{{asset('template/frontend/img/demos/real-estate/icons/arrow-right.svg')}}" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-secondary custom-card-info-arrow p-absolute top-5 mt-2 me-3'}" />
												</span>
                                    <span class="custom-card-info-content d-block">
													<h4 class="text-dark mb-1 text-5">South Miami</h4>
													<ul class="list list-unstyled list-inline mb-0">
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Beds: 3</strong>
														</li>
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Baths: 2</strong>
														</li>
														<li class="list-inline-item me-0 mb-0">
															<strong class="text-default text-uppercase text-3">Sq Ft: 500</strong>
														</li>
													</ul>
												</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 pb-4 mb-1">
                        <div class="card custom-card-info custom-card-info-shadow border-0">
                            <div class="card-body overflow-hidden p-relative z-index-1">
                                <a href="demo-real-estate-properties-detail.html" class="text-decoration-none">
                                    <span class="custom-card-info-type bg-primary text-color-light px-3 py-1 text-1 font-weight-semibold text-uppercase d-inline-block p-absolute top-8 left-8">For Sale</span>
                                    <span class="custom-card-info-img d-block">
													<img src="{{asset('template/frontend/img/demos/real-estate/listing/listing-1-thumb.jpg')}}" class="img-fluid">
												</span>
                                    <span class="custom-card-info-header d-block p-relative">
													<strong class="text-dark text-4">$ 1.250.000</strong>
													<img width="27" height="27" src="{{asset('template/frontend/img/demos/real-estate/icons/arrow-right.svg')}}" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-secondary custom-card-info-arrow p-absolute top-5 mt-2 me-3'}" />
												</span>
                                    <span class="custom-card-info-content d-block">
													<h4 class="text-dark mb-1 text-5">South Miami</h4>
													<ul class="list list-unstyled list-inline mb-0">
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Beds: 3</strong>
														</li>
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Baths: 2</strong>
														</li>
														<li class="list-inline-item me-0 mb-0">
															<strong class="text-default text-uppercase text-3">Sq Ft: 500</strong>
														</li>
													</ul>
												</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 pb-4 mb-1">
                        <div class="card custom-card-info custom-card-info-shadow border-0">
                            <div class="card-body overflow-hidden p-relative z-index-1">
                                <a href="demo-real-estate-properties-detail.html" class="text-decoration-none">
                                    <span class="custom-card-info-type bg-primary text-color-light px-3 py-1 text-1 font-weight-semibold text-uppercase d-inline-block p-absolute top-8 left-8">For Sale</span>
                                    <span class="custom-card-info-img d-block">
													<img src="{{asset('template/frontend/img/demos/real-estate/listing/listing-2-thumb.jpg')}}" class="img-fluid">
												</span>
                                    <span class="custom-card-info-header d-block p-relative">
													<strong class="text-dark text-4">$ 1.250.000</strong>
													<img width="27" height="27" src="{{asset('template/frontend/img/demos/real-estate/icons/arrow-right.svg')}}" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-secondary custom-card-info-arrow p-absolute top-5 mt-2 me-3'}" />
												</span>
                                    <span class="custom-card-info-content d-block">
													<h4 class="text-dark mb-1 text-5">South Miami</h4>
													<ul class="list list-unstyled list-inline mb-0">
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Beds: 3</strong>
														</li>
														<li class="list-inline-item me-2 mb-0">
															<strong class="text-default text-uppercase text-3">Baths: 2</strong>
														</li>
														<li class="list-inline-item me-0 mb-0">
															<strong class="text-default text-uppercase text-3">Sq Ft: 500</strong>
														</li>
													</ul>
												</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex pt-3">
                    <div class="mx-auto">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <section class="section section-height-3 bg-secondary border-0 m-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9 text-center text-lg-start mb-4 mb-lg-0">
                    <h2 class="mb-4 text-color-light mb-0">For <span class="font-weight-extra-bold">Residential And Commercial </span> Properties</h2>
                    <p class="font-weight-semibold text-color-light text-4 opacity-7 mb-0">Our Staff is trained to find any location you need!</p>
                </div>
                <div class="col-lg-3">
                    <div class="d-grid gap-2">
                        <a href="demo-real-estate-contact.html" class="btn btn-primary font-weight-semibold border-0 text-3 text-uppercase mt-4 btn-py-3">Contact Us
                            <img width="27" height="27" src="img/demos/real-estate/icons/arrow-right.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-light d-inline-block p-relative bottom-2 ms-2'}" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-front.front-end-template>
