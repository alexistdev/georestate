<x-front.front-end-template :title="$judul" :main-label="$menuUtama" :secondary-label="$menuKedua">
    <section class="page-header page-header-modern bg-color-primary border-0 m-0">
        <div class="container position-relative z-index-2">
            <div class="row text-center text-md-start py-5">
                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="font-weight-bold text-color-light text-8 mb-0">1234 SW 63rd Ave</h1>
                    <p class="text-color-light opacity-7 mb-0">South Miami</p>
                </div>
                <div class="col-md-4 order-1 order-md-2 align-self-center">
                    <ul class="breadcrumb breadcrumb-light d-block text-md-end text-4 mb-0">
                        <li><a href="#" class="text-decoration-none">Home</a></li>
                        <li class="text-upeercase active">Properties</li>
                    </ul>
                </div>
            </div>
        </div>

    </section>

    <div class="container py-5 my-3">
        <div class="row">
            <div class="col-lg-9">

                <div class="row">
                    <div class="col-lg-7">

                        <div class="thumb-gallery">
                            <div class="lightbox" data-plugin-options="{'delegate': 'a', 'type': 'image', 'gallery': {'enabled': true}}">
                                <div class="owl-carousel owl-theme manual thumb-gallery-detail show-nav-hover" id="thumbGalleryDetail">
                                    <div class="border-radius overflow-hidden">
                                        <a href="{{asset('template/frontend/img/demos/real-estate/listing/listing-detail-1.jpg')}}">
														<span class="thumb-info thumb-info-centered-info thumb-info-no-borders text-4">
															<span class="thumb-info-wrapper text-4">
																<img alt="Property Detail" src="{{asset('template/frontend/img/demos/real-estate/listing/listing-detail-1.jpg')}}" class="img-fluid">
																<span class="thumb-info-title text-4">
																	<span class="thumb-info-inner text-4"><i class="icon-magnifier icons text-4"></i></span>
																</span>
															</span>
														</span>
                                        </a>
                                    </div>
                                    <div class="border-radius overflow-hidden">
                                        <a href="{{asset('template/frontend/img/demos/real-estate/listing/listing-detail-2.jpg')}}">
														<span class="thumb-info thumb-info-centered-info thumb-info-no-borders text-4">
															<span class="thumb-info-wrapper text-4">
																<img alt="Property Detail" src="{{asset('template/frontend/img/demos/real-estate/listing/listing-detail-2.jpg')}}" class="img-fluid">
																<span class="thumb-info-title text-4">
																	<span class="thumb-info-inner text-4"><i class="icon-magnifier icons text-4"></i></span>
																</span>
															</span>
														</span>
                                        </a>
                                    </div>
                                    <div class="border-radius overflow-hidden">
                                        <a href="{{asset('template/frontend/img/demos/real-estate/listing/listing-detail-3.jpg')}}">
														<span class="thumb-info thumb-info-centered-info thumb-info-no-borders text-4">
															<span class="thumb-info-wrapper text-4">
																<img alt="Property Detail" src="{{asset('template/frontend/img/demos/real-estate/listing/listing-detail-3.jpg')}}" class="img-fluid">
																<span class="thumb-info-title text-4">
																	<span class="thumb-info-inner text-4"><i class="icon-magnifier icons text-4"></i></span>
																</span>
															</span>
														</span>
                                        </a>
                                    </div>
                                    <div class="border-radius overflow-hidden">
                                        <a href="{{asset('template/frontend/img/demos/real-estate/listing/listing-detail-4.jpg')}}">
														<span class="thumb-info thumb-info-centered-info thumb-info-no-borders text-4">
															<span class="thumb-info-wrapper text-4">
																<img alt="Property Detail" src="{{asset('template/frontend/img/demos/real-estate/listing/listing-detail-4.jpg')}}" class="img-fluid">
																<span class="thumb-info-title text-4">
																	<span class="thumb-info-inner text-4"><i class="icon-magnifier icons text-4"></i></span>
																</span>
															</span>
														</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="owl-carousel owl-theme manual thumb-gallery-thumbs mt" id="thumbGalleryThumbs">
                                <div class="border-radius overflow-hidden">
                                    <img alt="Property Detail" src="{{asset('template/frontend/img/demos/real-estate/listing/listing-detail-1-thumb.jpg')}}" class="img-fluid cur-pointer">
                                </div>
                                <div class="border-radius overflow-hidden">
                                    <img alt="Property Detail" src="{{asset('template/frontend/img/demos/real-estate/listing/listing-detail-2-thumb.jpg')}}" class="img-fluid cur-pointer">
                                </div>
                                <div class="border-radius overflow-hidden">
                                    <img alt="Property Detail" src="{{asset('template/frontend/img/demos/real-estate/listing/listing-detail-3-thumb.jpg')}}" class="img-fluid cur-pointer">
                                </div>
                                <div class="border-radius overflow-hidden">
                                    <img alt="Property Detail" src="{{asset('template/frontend/img/demos/real-estate/listing/listing-detail-4-thumb.jpg')}}" class="img-fluid cur-pointer">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-5">

                        <div class="border-radius overflow-hidden">
                            <table class="table table-striped">
                                <colgroup>
                                    <col width="35%">
                                    <col width="65%">
                                </colgroup>
                                <tbody>
                                <tr>
                                    <td class="bg-color-secondary text-light align-middle font-weight-semibold">
                                        Price
                                    </td>
                                    <td class="text-4 font-weight-bold align-middle bg-color-secondary text-light">
                                        $3,595,000
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold">
                                        Listing ID
                                    </td>
                                    <td>
                                        #123456
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold">
                                        Address
                                    </td>
                                    <td>
                                        1234 SW 63rd Ave - South Miami - Florida<br><a href="#map" class="text-2" data-hash data-hash-offset="0" data-hash-offset-lg="100">(Map Location)</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold">
                                        Neighborhood
                                    </td>
                                    <td>
                                        Porto Village
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold">
                                        Beds
                                    </td>
                                    <td>
                                        7
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold">
                                        Baths
                                    </td>
                                    <td>
                                        8
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold">
                                        Garages
                                    </td>
                                    <td>
                                        2
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold">
                                        Living Area
                                    </td>
                                    <td>
                                        8,000
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold">
                                        Lot Size
                                    </td>
                                    <td>
                                        20,000
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold">
                                        Year Built
                                    </td>
                                    <td>
                                        1999
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col">

                        <h3 class="mt-5 mb-3">Description</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pellentesque neque eget diam posuere porta. Quisque ut nulla at nunc <a href="#">vehicula</a> lacinia. Proin adipiscing porta tellus, ut feugiat nibh adipiscing sit amet. In eu justo a felis faucibus ornare vel id metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</p>

                        <p>Ctrices posuere cubilia Curae; In eu libero ligula. Fusce eget metus lorem, ac feugiat nibh adipiscing sit amet. In eu juiverra leo. Vestibulum ante ipsum primis in faucibus orci.</p>

                        <hr class="solid my-5">

                        <h3 class="mt-5 mb-3">Features</h3>

                        <ul class="list list-icons list-secondary row m-0">
                            <li class="col-sm-6 col-lg-4"><i class="fas fa-check"></i> Air conditioning <a href="#" data-bs-toggle="tooltip" data-bs-animation="false" data-bs-placement="top" title="+ Central Heating"><i class="fas fa-info-circle"></i></a></li>
                            <li class="col-sm-6 col-lg-4"><i class="fas fa-check"></i> Home Theater</li>
                            <li class="col-sm-6 col-lg-4"><i class="fas fa-check"></i> Central Heating</li>
                            <li class="col-sm-6 col-lg-4"><i class="fas fa-check"></i> Laundry</li>
                            <li class="col-sm-6 col-lg-4"><i class="fas fa-check"></i> Balcony</li>
                            <li class="col-sm-6 col-lg-4 custom-list-item-disabled"><i class="fas fa-check"></i> Storage</li>
                            <li class="col-sm-6 col-lg-4 custom-list-item-disabled"><i class="fas fa-check"></i> Garage</li>
                            <li class="col-sm-6 col-lg-4 custom-list-item-disabled"><i class="fas fa-check"></i> Yard</li>
                            <li class="col-sm-6 col-lg-4"><i class="fas fa-check"></i> Electric Water Heater</li>
                            <li class="col-sm-6 col-lg-4"><i class="fas fa-check"></i> Deck</li>
                            <li class="col-sm-6 col-lg-4"><i class="fas fa-check"></i> Gym</li>
                            <li class="col-sm-6 col-lg-4"><i class="fas fa-check"></i> Ocean View</li>
                        </ul>

                        <hr class="solid my-5">

                        <div id="map">
                            <h3 class="mt-5 mb-3">Map Location</h3>
                            <div class="border-radius overflow-hidden mt-0 mb-4">
                                <div id="googlemaps" class="google-map m-0"></div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-12">
                        <div class="card custom-card-info custom-card-info-shadow bg-color-primary text-color-light border-0 mb-4">
                            <div class="card-body bg-transparent p-relative p-4 my-2 text-center z-index-1">
                                <h3 class="text-color-light font-weight-semibold text-5 d-block mb-4">Our Agents</h3>

                                <div class="owl-carousel owl-theme dots-light mb-0 pb-0" data-plugin-options="{'items': 1, 'autoplay': true, 'autoplayTimeout': 5000, 'margin': 10}">
                                    <div>
                                        <a href="#" class="text-decoration-none">
                                            <img alt="" class="img-fluid rounded-circle m-auto" src="{{asset('template/frontend/img/team/team-5.jpg')}}" style="max-width: 110px;">
                                            <strong class="text-color-light font-weight-semibold text-4 line-height-5 d-block mt-3 mb-1 text-center">John Doe</strong>
                                        </a>
                                        <a class="opacity-7 text-color-light d-block text-center line-height-5 text-3" href="tel:12345678">(800) 123-4567</a>
                                        <a class="opacity-7 text-color-light d-block text-center line-height-5 text-3 pb-2" href="mailto:you@domain.com">you@domain.com</a>
                                    </div>
                                    <div>
                                        <a href="#" class="text-decoration-none">
                                            <img alt="" class="img-fluid rounded-circle m-auto" src="{{asset('template/frontend/img/team/team-4.jpg')}}" style="max-width: 110px;">
                                            <strong class="text-color-light font-weight-semibold text-4 line-height-5 d-block mt-3 mb-1 text-center">Janice Doe</strong>
                                        </a>
                                        <a class="opacity-7 text-color-light d-block text-center line-height-5 text-3" href="tel:12345678">(800) 123-4567</a>
                                        <a class="opacity-7 text-color-light d-block text-center line-height-5 text-3 pb-2" href="mailto:you@domain.com">you@domain.com</a>
                                    </div>
                                    <div>
                                        <a href="#" class="text-decoration-none">
                                            <img alt="" class="img-fluid rounded-circle m-auto" src="{{asset('template/frontend/img/team/team-2.jpg')}}" style="max-width: 110px;">
                                            <strong class="text-color-light font-weight-semibold text-4 line-height-5 d-block mt-3 mb-1 text-center">Lisa Doe</strong>
                                        </a>
                                        <a class="opacity-7 text-color-light d-block text-center line-height-5 text-3" href="tel:12345678">(800) 123-4567</a>
                                        <a class="opacity-7 text-color-light d-block text-center line-height-5 text-3 pb-2" href="mailto:you@domain.com">you@domain.com</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-12">
                        <h3 class="mt-2 mb-3 font-weight-semibold text-5">Related Properties</h3>
                        <div class="owl-carousel owl-theme mb-0 pb-4" data-plugin-options="{'items': 1, 'autoplay': true, 'autoplayTimeout': 5000, 'margin': 10}">
                            <div>
                                <div class="card custom-card-info border-0">
                                    <div class="card-body overflow-hidden p-relative z-index-1">
                                        <a href="#" class="text-decoration-none">
                                            <span class="custom-card-info-type bg-primary text-color-light px-3 py-1 text-1 font-weight-semibold text-uppercase d-inline-block p-absolute top-8 left-8">For Sale</span>
                                            <span class="custom-card-info-img d-block">
															<img src="{{asset('template/frontend/img/demos/real-estate/listing/listing-1-thumb.jpg')}}" class="img-fluid">
														</span>
                                            <span class="custom-card-info-header d-block p-relative">
															<strong class="text-dark text-4">$ 1.250.000</strong>
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
                            <div>
                                <div class="card custom-card-info border-0">
                                    <div class="card-body overflow-hidden p-relative z-index-1">
                                        <a href="#" class="text-decoration-none">
                                            <span class="custom-card-info-type bg-primary text-color-light px-3 py-1 text-1 font-weight-semibold text-uppercase d-inline-block p-absolute top-8 left-8">For Sale</span>
                                            <span class="custom-card-info-img d-block">
															<img src="{{asset('template/frontend/img/demos/real-estate/listing/listing-1-thumb.jpg')}}" class="img-fluid">
														</span>
                                            <span class="custom-card-info-header d-block p-relative">
															<strong class="text-dark text-4">$ 1.250.000</strong>
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
                            <div>
                                <div class="card custom-card-info border-0">
                                    <div class="card-body overflow-hidden p-relative z-index-1">
                                        <a href="#" class="text-decoration-none">
                                            <span class="custom-card-info-type bg-primary text-color-light px-3 py-1 text-1 font-weight-semibold text-uppercase d-inline-block p-absolute top-8 left-8">For Sale</span>
                                            <span class="custom-card-info-img d-block">
															<img src="{{asset('template/frontend/img/demos/real-estate/listing/listing-1-thumb.jpg')}}" class="img-fluid">
														</span>
                                            <span class="custom-card-info-header d-block p-relative">
															<strong class="text-dark text-4">$ 1.250.000</strong>
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
                    </div>

                    <div class="col-12">
                        <div class="card custom-card-info bg-color-quaternary border-0 mb-4">
                            <div class="card-body bg-transparent p-relative p-4 m-2 z-index-1">
                                <h3 class="text-color-dark font-weight-semibold text-5 d-block mt-1 mb-2">Contact Us</h3>

                                <p>
                                    We help you choose your property and any other question.
                                </p>

                                <form class="contact-form form-style-3" action="" method="POST">
                                    <div class="contact-form-success alert alert-success d-none mt-4">
                                        <strong>Success!</strong> Your message has been sent to us.
                                    </div>

                                    <div class="contact-form-error alert alert-danger d-none mt-4">
                                        <strong>Error!</strong> There was an error sending your message.
                                        <span class="mail-error-message text-1 d-block"></span>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-2">
                                            <input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control bg-color-light box-shadow-none border-0" name="name" id="name" required placeholder="Name *">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-2">
                                            <input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control bg-color-light box-shadow-none border-0" name="email" id="email" required placeholder="E-mail *">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-2">
                                            <input type="text" value="" data-msg-required="Please enter your phone number." maxlength="100" class="form-control bg-color-light box-shadow-none border-0" name="phone" id="phone" required placeholder="Phone *">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-2">
                                            <textarea maxlength="5000" data-msg-required="Please enter your message." rows="5" class="form-control bg-color-light box-shadow-none border-0" name="message" id="message" required placeholder="Message *"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-0">
                                            <div class="d-grid gap-2">
                                                <button class="btn btn-secondary font-weight-semibold border-0 p-relative text-2 text-uppercase mt-1 btn-px-4 btn-py-2 mb-2" type="submit">Send Message</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
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
                        <a href="#" class="btn btn-primary font-weight-semibold border-0 text-3 text-uppercase mt-4 btn-py-3">Contact Us
                            <img width="27" height="27" src="{{asset('template/frontend/img/demos/real-estate/icons/arrow-right.svg')}}" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-light d-inline-block p-relative bottom-2 ms-2'}" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-front.front-end-template>
