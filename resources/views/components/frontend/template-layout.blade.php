<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{$judul}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="GeoRestate" />
    <meta name="description" content="GeoRestate -  Aplikasi manajemen Real Estate Terbaik">
    <meta name="author" content="alexistdev.com">

    <!-- Web Fonts  -->
    <link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CShadows+Into+Light&display=swap" rel="stylesheet" type="text/css">

    <x-frontend.header-layout />

</head>
<body class="loading-overlay-showing" data-loading-overlay data-plugin-options="{'hideDelay': 500}">
{{--<div class="loading-overlay">--}}
{{--    <div class="bounce-loader">--}}
{{--        <div class="bounce1"></div>--}}
{{--        <div class="bounce2"></div>--}}
{{--        <div class="bounce3"></div>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="body">
    <header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 70}">
        <div class="header-body border-top-0">
            <div class="header-top">
                <div class="container">
                    <div class="header-row py-2">
                        <div class="header-column justify-content-start">
                            <div class="header-row">
                                <nav class="header-nav-top">
                                    <ul class="list list-unstyled list-inline mb-0">
                                        <li class="list-inline-item me-4 mb-0">
                                            <i class="icons icon-phone text-color-secondary text-4 position-relative top-4 me-1"></i>
                                            <a href="tel:+1234567890" class="text-default text-hover-secondary font-weight-medium text-decoration-none text-2">
                                                (800) 123-4567
                                            </a>
                                        </li>
                                        <li class="list-inline-item me-4 mb-0 d-none d-lg-inline-block">
                                            <i class="icons icon-location-pin text-color-secondary text-4 position-relative top-4 me-1"></i>
                                            <a href="#" class="text-default text-hover-secondary font-weight-medium text-decoration-none text-2">
                                                1234 Porto Street, Los Angeles / LA
                                            </a>
                                        </li>
                                        <li class="list-inline-item me-4 mb-0 d-none d-md-inline-block">
                                            <i class="icons icon-envelope text-color-secondary text-4 position-relative top-4 me-1"></i>
                                            <a href="mailto:porto@portotheme.com" class="text-default text-hover-secondary font-weight-medium text-decoration-none text-2">
                                                porto@portotheme.com
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="header-column justify-content-end">
                            <div class="header-row">
                                <ul class="list list-unstyled list-inline mb-0">
                                    <li class="list-inline-item me-4 mb-0">
                                        <a href="blog-large-image-sidebar-right.html" class="text-default text-hover-secondary font-weight-semibold text-decoration-none text-1">
                                            BLOG
                                        </a>
                                    </li>
                                    <li class="list-inline-item me-0 mb-0">
                                        <a href="page-login.html" class="text-default text-hover-secondary font-weight-semibold text-decoration-none text-1">
                                            LOGIN/REGISTER
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-container container">
                <div class="header-row">
                    <div class="header-column">
                        <div class="header-row">
                            <div class="header-logo">
                                <a href="demo-real-estate.html">
                                    <img alt="Porto" width="123" height="48" data-sticky-width="123" data-sticky-height="48" src="img/demos/real-estate/logo.png">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="header-column justify-content-end">
                        <div class="header-row">
                            <div class="header-nav header-nav-links order-2 order-lg-1">
                                <div class="header-nav-main header-nav-main-square header-nav-main-dropdown-no-borders header-nav-main-dropdown-modern header-nav-main-effect-2 header-nav-main-sub-effect-1">
                                    <nav class="collapse">
                                        <ul class="nav nav-pills" id="mainNav">
                                            <li>
                                                <a class="nav-link active" href="demo-real-estate.html">
                                                    Home
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="demo-real-estate-properties.html">
                                                    Properties
                                                </a>
                                            </li>
                                            <li class="dropdown">
                                                <a class="nav-link dropdown-toggle" href="#">
                                                    About
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="demo-real-estate-agents.html">Agents</a></li>
                                                    <li><a class="dropdown-item" href="demo-real-estate-who-we-are.html">Who We Are</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="demo-real-estate-contact.html">
                                                    Contact
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="elements.html">
                                                    Elements
                                                </a>
                                            </li>
                                            <li class="dropdown dropdown-mega" id="headerSearchProperties">
                                                <a class="nav-link dropdown-toggle" href="#">
                                                    <i class="fas fa-search me-2"></i> Search
                                                </a>
                                                <ul class="dropdown-menu custom-fullwidth-dropdown-menu ms-0">
                                                    <li>
                                                        <div class="dropdown-mega-content mt-3 mt-lg-0">
                                                            <form class="form-style-3" id="propertiesFormHeader" action="demo-real-estate-properties.html" method="POST">
                                                                <div class="container p-0">
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
                                                                                <input type="submit" value="Search Now" class="btn btn-secondary font-weight-semibold border-0 p-relative bottom-3 text-1 text-uppercase mt-1 btn-px-4 btn-py-2">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                <button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
                                    <i class="fas fa-bars"></i>
                                </button>
                            </div>
                            <div class="header-nav-features header-nav-features-no-border header-nav-features-lg-show-border order-1 order-lg-2">
                                <div class="header-nav-feature header-nav-features-search d-inline-flex">
                                    <ul class="header-social-icons social-icons social-icons-lg d-none d-sm-block social-icons-clean ms-0">
                                        <li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="text-4 fab fa-facebook-f"></i></a></li>
                                        <li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="text-4 fab fa-twitter"></i></a></li>
                                        <li class="social-icons-instagram"><a href="http://www.instagram.com/" target="_blank" title="Instagram"><i class="text-4 fab fa-instagram"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div role="main" class="main">

        {{$slot}}
        <!-- Start : Footer -->
        <x-frontend.footer-layout />
        <!-- End : Footer -->
    </div>
</div>

<!-- Start : Javascript -->
<x-frontend.js-layout />
<!-- End : Javascript -->
</body>
</html>
