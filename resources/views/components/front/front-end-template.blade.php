<!DOCTYPE html>
<html lang="id">
<head>

    <!-- Basic -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$title}}</title>

    <meta name="keywords" content="GeoRestate v.1.0" />
    <meta name="description" content="{{ config('georestate.tagline') }}">
    <meta name="author" content="alexistdev">

    <x-front.front-header-layout />
    @stack('customCSS')

</head>
{{--<body class="loading-overlay-showing" data-loading-overlay data-plugin-options="{'hideDelay': 500}">--}}
<body class="" data-loading-overlay data-plugin-options="{'hideDelay': 500}">
<div class="loading-overlay">
    <div class="bounce-loader">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>

<div class="body">
    <!-- Start: Menu -->
    <x-front.front-top-menu-layout :main-label="$mainLabel"/>
    <!-- End: Footer -->

    <div role="main" class="main">
        @if(session('favorit_success'))
            <div class="container pt-4">
                <div class="alert alert-success mb-0">
                    {{ session('favorit_success') }}
                    @auth <a href="{{ route('usr.favorit') }}" class="alert-link ms-1">Lihat Favorit Saya</a> @endauth
                </div>
            </div>
        @endif

        {{$slot}}

        <!-- Start: Footer -->
        <x-front.front-footer-layout />
        <!-- End: Footer -->
    </div>
</div>

<x-front.front-j-s-layout/>
@stack('customJS')

</body>
</html>
