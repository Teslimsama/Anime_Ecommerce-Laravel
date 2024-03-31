<!-- Meta Tag -->
@yield('meta')
<!-- Title Tag  -->
<title>@yield('title')</title>
<!-- Favicon -->
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="/storage/photos/favicomatic/apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/storage/photos/favicomatic/apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/storage/photos/favicomatic/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/storage/photos/favicomatic/apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="/storage/photos/favicomatic/apple-touch-icon-60x60.png" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="/storage/photos/favicomatic/apple-touch-icon-120x120.png" />
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="/storage/photos/favicomatic/apple-touch-icon-76x76.png" />
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="/storage/photos/favicomatic/apple-touch-icon-152x152.png" />
<link rel="icon" type="image/png" href="/storage/photos/favicomatic/favicon-196x196.png" sizes="196x196" />
<link rel="icon" type="image/png" href="/storage/photos/favicomatic/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/png" href="/storage/photos/favicomatic/favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="/storage/photos/favicomatic/favicon-16x16.png" sizes="16x16" />
<link rel="icon" type="image/png" href="/storage/photos/favicomatic/favicon-128.png" sizes="128x128" />
<meta name="application-name" content="Otaku Oasis"/>
<meta name="msapplication-TileColor" content="#FFFFFF" />
<meta name="msapplication-TileImage" content="/storage/photos/favicomatic/mstile-144x144.png" />
<meta name="msapplication-square70x70logo" content="/storage/photos/favicomatic/mstile-70x70.png" />
<meta name="msapplication-square150x150logo" content="/storage/photos/favicomatic/mstile-150x150.png" />
<meta name="msapplication-wide310x150logo" content="/storage/photos/favicomatic/mstile-310x150.png" />
<meta name="msapplication-square310x310logo" content="/storage/photos/favicomatic/mstile-310x310.png" />
<!-- Web Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

<!-- StyleSheet -->
<link rel="manifest" href="/manifest.json">
<!-- Bootstrap -->
<link rel="stylesheet" href="{{asset('frontend/css/bootstrap.css')}}">
<!-- Magnific Popup -->
<link rel="stylesheet" href="{{asset('frontend/css/magnific-popup.min.css')}}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{asset('frontend/css/font-awesome.css')}}">
<!-- Fancybox -->
<link rel="stylesheet" href="{{asset('frontend/css/jquery.fancybox.min.css')}}">
<!-- Themify Icons -->
<link rel="stylesheet" href="{{asset('frontend/css/themify-icons.css')}}">
<!-- Nice Select CSS -->
<link rel="stylesheet" href="{{asset('frontend/css/niceselect.css')}}">
<!-- Animate CSS -->
<link rel="stylesheet" href="{{asset('frontend/css/animate.css')}}">
<!-- Flex Slider CSS -->
<link rel="stylesheet" href="{{asset('frontend/css/flex-slider.min.css')}}">
<!-- Owl Carousel -->
<link rel="stylesheet" href="{{asset('frontend/css/owl-carousel.css')}}">
<!-- Slicknav -->
<link rel="stylesheet" href="{{asset('frontend/css/slicknav.min.css')}}">
<!-- Jquery Ui -->
<link rel="stylesheet" href="{{asset('frontend/css/jquery-ui.css')}}">

<!-- Eshop StyleSheet -->
<link rel="stylesheet" href="{{asset('frontend/css/reset.css')}}">
<link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
<link rel="stylesheet" href="{{asset('frontend/css/responsive.css')}}">
<style>
    /* Multilevel dropdown */
    .dropdown-submenu {
    position: relative;
    }

    .dropdown-submenu>a:after {
    content: "\f0da";
    float: right;
    border: none;
    font-family: 'FontAwesome';
    }

    .dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: 0px;
    margin-left: 0px;
    }

    /*
</style>
@stack('styles')
