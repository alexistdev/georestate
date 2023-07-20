<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Basic -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$title}}</title>

    <meta name="keywords" content="GeoRestate v.1.0" />
    <meta name="description" content="Aplikasi Agen Real Estate">
    <meta name="author" content="alexistdev">

    <x-front.front-header-layout />

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

        {{$slot}}

        <!-- Start: Footer -->
        <x-front.front-footer-layout />
        <!-- End: Footer -->
    </div>
</div>

<x-front.front-j-s-layout/>

</body>
</html>
