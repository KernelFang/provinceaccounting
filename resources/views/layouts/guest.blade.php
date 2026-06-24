<!DOCTYPE html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="bidding, fiverr, freelance marketplace, freelancers, freelancing, gigs, hiring, job board, job portal, job posting, jobs marketplace, peopleperhour, proposals, sell services, upwork">
    <meta name="description" content="Freeio - Freelance Marketplace HTML Template">
    <meta name="CreativeLayers" content="ATFN">

    <!-- Title -->
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- css file -->
    <link rel="stylesheet" href="{{ asset('theme/v1/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/ace-responsive-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/slider.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/v1/css/ud-custom-spacing.css') }}">

    <!-- Responsive stylesheet -->
    <link rel="stylesheet" href="{{ asset('theme/v1/css/responsive.css') }}">

    <!-- Favicon -->
    <link href="{{ asset('theme/v1/images/favicon.ico') }}" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
    <link href="{{ asset('theme/v1/images/favicon.ico') }}" sizes="128x128" rel="shortcut icon" />

    <!-- Apple Touch Icon -->
    <link href="{{ asset('theme/v1/images/apple-touch-icon-60x60.png') }}" sizes="60x60" rel="apple-touch-icon">
    <link href="{{ asset('theme/v1/images/apple-touch-icon-72x72.png') }}" sizes="72x72" rel="apple-touch-icon">
    <link href="{{ asset('theme/v1/images/apple-touch-icon-114x114.png') }}" sizes="114x114" rel="apple-touch-icon">
    <link href="{{ asset('theme/v1/images/apple-touch-icon-180x180.png') }}" sizes="180x180" rel="apple-touch-icon">

</head>

<body>
    <div class="wrapper ovh">
        <div class="preloader"></div>

        <!-- Main Header Nav -->
        <header class="header-nav nav-innerpage-style bg-transparent zi9 position-relative main-menu border-0">
            <!-- Ace Responsive Menu -->
            <nav class="posr" style="font-size: 1.15rem">
                <div class="container posr menu_bdrt1">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto px-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="logos mr30">
                                    <a class="header-logo logo2" href="index.html">
                                        <img src="{{ asset('theme/v1/images/logo.png') }}" alt="Gen Z Travels"
                                            style="width: 100px; height: auto;">
                                    </a>
                                </div>
                                <!-- Responsive Menu Structure-->
                                <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">
                                    <li><a class="list-item" href="{{ route('welcome') }}">Home</a></li>
                                    <li><a class="list-item" href="{{ route('home.about') }}">About</a></li>
                                    <li><a class="list-item" href="{{ route('home.contact') }}">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-auto px-0">
                            <div class="d-flex align-items-center">
                                @if (Route::has('login'))
                                    @auth
                                        <a href="{{ url('/account/dashboard') }}" class="">
                                            Dashboard
                                        </a>
                                    @else
                                        <a class="login-info mr10-lg mr30"
                                            href="{{ route('login') }}">{{ __('Sign in') }}</a>

                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="ud-btn btn-thm2 add-joining">
                                                {{ __('Sign up') }}
                                            </a>
                                        @endif
                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <div class="hiddenbar-body-ovelay"></div>

        <!-- Mobile Nav  -->
        <div id="page" class="mobilie_header_nav stylehome1">
            <div class="mobile-menu">
                <div class="header bdrb1">
                    <div class="menu_and_widgets">
                        <div class="mobile_menu_bar d-flex justify-content-between align-items-center">
                            <a class="mobile_logo" href="#">
                                <img src="{{ asset('theme/v1/images/logo.png') }}" alt="Header Logo"
                                    style="width: 50px; height: auto;">
                            </a>
                            <div class="right-side text-end">
                                @if (Route::has('login'))
                                    @auth
                                        <a href="{{ url('/account/dashboard') }}" class="">
                                            Dashboard
                                        </a>
                                    @else
                                        <a class="" href="{{ route('login') }}">Sign in</a>
                                    @endauth
                                @endif
                                <a class="menubar ml30" href="#menu">
                                    <img src="{{ asset('theme/v1/images/mobile-dark-nav-icon.svg') }}"
                                        alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="posr">
                        <div class="mobile_menu_close_btn"><span class="far fa-times"></span></div>
                    </div>
                </div>
            </div>
            <!-- /.mobile-menu -->
            <nav id="menu" class="">
                <ul>
                    <li><a href="">Home</a></li>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/account/dashboard') }}" class="">
                                Dashboard
                            </a>
                        @else
                            <li>
                                <a class="login-info" href="{{ route('login') }}">{{ __('Sign in') }}</a>
                            </li>

                            @if (Route::has('register'))
                                <li>
                                    <a class="login-info" href="{{ route('register') }}">{{ __('Sign up') }}</a>
                                </li>
                            @endif
                        @endauth
                    @endif

                    <!-- Only for Mobile View -->
                </ul>
            </nav>
        </div>

        <div class="body_content">

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer -->
            <section class="footer-style1 at-home7 pt25 pb-0">
                <div class="container">
                    <div class="row bdrb1 pb10 mb60">
                        <div class="col-md-7">
                            <div
                                class="d-block text-center text-md-start justify-content-center justify-content-md-start d-md-flex align-items-center mb-3 mb-md-0">
                                <a class="fz17 fw500 mr15-md mr30" href="">Terms of Service</a>
                                <a class="fz17 fw500 mr15-md mr30" href="">Privacy Policy</a>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="social-widget text-center text-md-end">
                                <div class="social-style1 light-style2">
                                    <a class="me-2 fw500 fz17" href="">Follow us</a>
                                    <a href=""><i class="fab fa-facebook-f list-inline-item"></i></a>
                                    <a href=""><i class="fab fa-twitter list-inline-item"></i></a>
                                    <a href=""><i class="fab fa-instagram list-inline-item"></i></a>
                                    <a href=""><i class="fab fa-linkedin-in list-inline-item"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="link-style1 light-style at-home8 mb-4 mb-sm-5">
                                <h5 class="mb15">About</h5>
                                <div class="link-list">
                                    <a href="{{ route('home.about') }}">About Us</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="link-style1 light-style at-home8 mb-4 mb-sm-5">
                                <h5 class="mb15">Contact</h5>
                                <ul class="ps-0">
                                    <a href="{{ route('home.contact') }}">Contact Us</a>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="link-style1 light-style at-home8 mb-4 mb-sm-5">
                                <h5 class="mb15">Service</h5>
                                <ul class="ps-0">
                                    <li><a href="{{ route('home.service') }}">Our Service</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="link-style1 light-style at-home8 mb-4 mb-sm-5">
                                <h5 class="mb15">Club</h5>
                                <ul class="ps-0">
                                    <li><a href="#">Youth Club</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container bdrt1 py-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <p class="copyright-text mb-2 mb-md0 text-dark-light ff-heading small">©
                                    Gen Z Travels, 2025. All rights reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <a class="scrollToHome" href="#"><i class="fas fa-angle-up"></i></a>
        </div>
    </div>
    <!-- Wrapper End -->
    <script src="{{ asset('theme/v1/js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('theme/v1/js/jquery-migrate-3.0.0.min.js') }}"></script>
    <script src="{{ asset('theme/v1/js/popper.min.js') }}"></script>
    <script src="{{ asset('theme/v1/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/v1/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('theme/v1/js/jquery.mmenu.all.js') }}"></script>
    <script src="{{ asset('theme/v1/js/ace-responsive-menu.js') }}"></script>
    <script src="{{ asset('theme/v1/js/jquery-scrolltofixed-min.js') }}"></script>
    <script src="{{ asset('theme/v1/js/wow.min.js') }}"></script>
    <script src="{{ asset('theme/v1/js/owl.js') }}"></script>
    <script src="{{ asset('theme/v1/js/jquery.counterup.js') }}"></script>
    <script src="{{ asset('theme/v1/js/isotop.js') }}"></script>
    <!-- Custom script for all pages -->
    <script src="{{ asset('theme/v1/js/script.js') }}"></script>

    <!-- Blade Placeholder for dynamic JS -->
    @isset($script)
        {!! $script !!}
    @endisset
</body>

</html>
