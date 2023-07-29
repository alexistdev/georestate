<x-front.front-end-template :title="$judul" :main-label="$menuUtama" :secondary-label="$menuKedua">
    <section class="page-header page-header-modern bg-color-primary border-0 m-0">
        <div class="container position-relative z-index-2">
            <div class="row text-center text-md-start py-5">
                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="font-weight-bold text-color-light text-8 mb-0">Contact</h1>
                    <p class="text-color-light opacity-7 mb-0"></p>
                </div>
                <div class="col-md-4 order-1 order-md-2 align-self-center">
                    <ul class="breadcrumb breadcrumb-light d-block text-md-end text-4 mb-0">
                        <li><a href="#" class="text-decoration-none">Home</a></li>
                        <li class="text-upeercase active">Contact</li>
                    </ul>
                </div>
            </div>
        </div>

    </section>

    <div class="container py-5 my-3">
        <div class="row">
            <div class="col-lg-9">

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
                                    <textarea maxlength="5000" data-msg-required="Please enter your message." rows="13" class="form-control bg-color-light box-shadow-none border-0" name="message" id="message" required placeholder="Message *"></textarea>
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

                <hr class="solid my-5">

                <div id="map">
                    <h3 class="mt-5 mb-3">Location</h3>
                    <div class="border-radius overflow-hidden mt-0 mb-4">
                        <div id="googlemaps" class="google-map m-0"></div>
                    </div>
                </div>

            </div>
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-12">
                        <h3 class="mt-2 mb-1 font-weight-semibold text-5">Address</h3>
                        <ul class="list-unstyled mt-0 mb-4">
                            <li>12345  Porto Blvd.</li>
                            <li>Suite 1500</li>
                            <li>Los Angeles, California 90000</li>
                        </ul>

                        <h3 class="mt-2 mb-1 font-weight-semibold text-5">Email</h3>
                        <ul class="list-unstyled mt-0 mb-4">
                            <li><a href="mailto:porto@portotheme.com">porto@portotheme.com</a></li>
                        </ul>

                        <h3 class="mt-2 mb-1 font-weight-semibold text-5">Phone</h3>
                        <ul class="list-unstyled mt-0 mb-4">
                            <li><a href="tel:1234567">(800) 123-4567</a></li>
                        </ul>

                        <h3 class="mt-2 mb-1 font-weight-semibold text-5">Careers & Press</h3>
                        <ul class="list-unstyled mt-0 mb-4">
                            <li><a href="tel:1234567">(800) 123-4567</a></li>
                        </ul>

                        <h3 class="mt-2 mb-1 font-weight-semibold text-5">Follow Us</h3>
                        <ul class="social-icons social-icons-clean social-icons-icon-dark social-icons-medium mt-3 mb-4">
                            <li class="social-icons-facebook">
                                <a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li class="social-icons-twitter">
                                <a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li class="social-icons-linkedin">
                                <a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a>
                            </li>
                        </ul>
                    </div>

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
                        <h3 class="mt-2 mb-3 font-weight-semibold text-5">Featured Properties</h3>
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

                </div>
            </div>
        </div>
    </div>
</x-front.front-end-template>
