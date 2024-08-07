<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}} | AI Generator for Faceless videos on Tiktok and Youtube</title>
    <meta name="description" content="AI-powered tool for creating engaging faceless videos on TikTok and YouTube.">
    <meta name="keywords" content="ai, shorts, faceless, youtube, tiktok, video, generator">
    <link rel="canonical" href="{{ config('app.url') }}">
    <meta name="theme-color" content="#178d72">

    <!-- Open Graph Tags -->
    <!-- <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Lexend">
    <meta property="og:description" content="Full-featured, Professional-looking SaaS, Software and Startup Site Template.">
    <meta property="og:url" content="https://unistudio.co/html/lexend/">
    <meta property="og:site_name" content="Lexend">
    <meta property="og:image" content="https://unistudio.co/html/lexend/assets/images/common/seo-image.jpg">
    <meta property="og:image:width" content="1180">
    <meta property="og:image:height" content="600">
    <meta property="og:image:type" content="image/png"> -->

    <!-- Twitter Card Tags -->
    <!-- <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Lexend">
    <meta name="twitter:description" content="Full-featured, Professional-looking SaaS, Software and Startup Site Template.">
    <meta name="twitter:image" content="https://unistudio.co/html/lexend/assets/images/common/seo-image.jpg"> -->

    <link rel="canonical" href="{{ config('app.url') }}">

    <!-- preload head styles -->
    <link rel="preload" href="../assets/css/unicons.min.css" as="style">
    <link rel="preload" href="../assets/css/swiper-bundle.min.css" as="style">

    <!-- preload footer scripts -->
    <link rel="preload" href="../assets/js/libs/jquery.min.js" as="script">
    <link rel="preload" href="../assets/js/libs/scrollmagic.min.js" as="script">
    <link rel="preload" href="../assets/js/libs/swiper-bundle.min.js" as="script">
    <link rel="preload" href="../assets/js/libs/anime.min.js" as="script">
    <link rel="preload" href="../assets/js/helpers/data-attr-helper.js" as="script">
    <link rel="preload" href="../assets/js/helpers/swiper-helper.js" as="script">
    <link rel="preload" href="../assets/js/helpers/anime-helper.js" as="script">
    <link rel="preload" href="../assets/js/helpers/anime-helper-defined-timelines.js" as="script">
    <link rel="preload" href="../assets/js/uikit-components-bs.js" as="script">
    <link rel="preload" href="../assets/js/app.js" as="script">

    <!-- app head for bootstrap core -->
    <script src="../assets/js/app-head-bs.js"></script>

    <!-- include uni-core components -->
    <link rel="stylesheet" href="../assets/js/uni-core/css/uni-core.min.css">

    <!-- include styles -->
    <link rel="stylesheet" href="../assets/css/unicons.min.css">
    <link rel="stylesheet" href="../assets/css/prettify.min.css">
    <link rel="stylesheet" href="../assets/css/swiper-bundle.min.css">

    <!-- include main style -->
    <link rel="stylesheet" href="../assets/css/theme/theme-two.min.purge.css">

    <!-- include custom style -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    <!-- include scripts -->
    <script src="../assets/js/uni-core/js/uni-core-bundle.min.js"></script>
</head>

<body class="uni-body panel bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100 overflow-x-hidden">

    <!--  Menu panel -->
    @if($showMenuPanel === true)
    <div id="uc-menu-panel" data-uc-offcanvas="overlay: true;">
        <div class="uc-offcanvas-bar bg-white text-dark dark:bg-gray-900 dark:text-white">
            <header class="uc-offcanvas-header hstack justify-between items-center pb-2 bg-white dark:bg-gray-900">
                <div class="uc-logo">
                    <a href="{{ config('app.url') }}" class="h5 text-none text-gray-900 dark:text-white">
                        <!-- <img class="w-32px" src="../assets/images/common/logo-mark.svg" alt="{{ config('app.name') }}"> -->
                        <img src="{{ asset('assets/images/common/logo-light.svg') }}" alt="{{ config('app.name') }}">
                    </a>
                </div>
                <button class="uc-offcanvas-close rtl:end-auto rtl:start-0 m-1 mt-2 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all" type="button">
                    <i class="unicon-close"></i>
                </button>
            </header>

            <div class="panel">
                <!-- <form id="search-panel" class="form-icon-group vstack gap-1 mb-2" data-uc-sticky="">
                    <input type="email" class="form-control form-control-sm fs-7 rounded-default" placeholder="Search..">
                    <span class="form-icon text-gray">
                        <i class="unicon-search icon-1"></i>
                    </span>
                </form> -->
                <ul class="nav-y gap-narrow fw-medium fs-6" data-uc-nav="">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#how_it_works">How it works</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#faq">FAQs</a></li>

                    <li class="hr opacity-10 my-1"></li>
                    @if (Route::has('login'))
                    @auth
                    <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                    @else
                    <li><a href="{{ route('login') }}">Sign In</a></li>

                    @if (Route::has('register'))
                    <li><a href="{{ route('register') }}">Register</a></li>
                    @endif
                    @endauth
                    @endif
                </ul>
                <ul class="social-icons nav-x mt-4">
                    <li>
                        <a href="#"><i class="unicon-logo-medium icon-2"></i></a>
                        <a href="#"><i class="unicon-logo-x-filled icon-2"></i></a>
                        <a href="#"><i class="unicon-logo-instagram icon-2"></i></a>
                        <a href="#"><i class="unicon-logo-pinterest icon-2"></i></a>
                    </li>
                </ul>
                <div class="py-2 hstack gap-2 mt-4 bg-white dark:bg-gray-900" data-uc-sticky="position: bottom">
                    <div class="vstack gap-1">
                        <span class="fs-7 opacity-60">Select theme:</span>
                        <div class="darkmode-trigger" data-darkmode-switch="">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider fs-5"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!--  Bottom Actions Sticky -->
    @if($showBottomActionsSticky === true)
    <div class="backtotop-wrap position-fixed bottom-0 end-0 z-99 m-2 vstack">
        <div class="darkmode-trigger cstack w-40px h-40px rounded-circle text-none bg-gray-100 dark:bg-gray-700 dark:text-white" data-darkmode-toggle="">
            <label class="switch">
                <span class="sr-only">Dark mode toggle</span>
                <input type="checkbox">
                <span class="slider fs-5"></span>
            </label>
        </div>
        <a class="btn btn-sm bg-primary text-white w-40px h-40px rounded-circle" href="to_top" data-uc-backtotop>
            <i class="icon-2 unicon-chevron-up"></i>
        </a>
    </div>
    @endif

    <!-- Header start -->
    @if($showHeader)
    <header class="uc-header header-six uc-navbar-sticky-wrap z-999" data-uc-sticky="start: 1200px; animation: uc-animation-slide-top; sel-target: .uc-navbar-container; cls-active: uc-navbar-sticky; cls-inactive: uc-navbar-transparent; end: !*;">
        <nav class="uc-navbar-container lg:mt-3 rounded-0 lg:rounded-pill uc-navbar-float ft-tertiary z-1" data-anime="translateY: [-40, 0]; opacity: [0, 1]; easing: easeOutExpo; duration: 750; delay: 0;">
            <div class="uc-navbar-main" style="--uc-nav-height: 80px">
                <div class="container max-w-lg lg:max-w-950px xl:max-w-xl">
                    <div class="uc-navbar min-h-64px lg:min-h-80px px-2 lg:px-0 text-gray-900 dark:text-white" data-uc-navbar="mode: click; animation: uc-animation-slide-top-small; duration: 150;">
                        <div class="uc-navbar-left">
                            <div>
                                <a class="panel text-none fs-5 fw-bold" href="index-6.html">
                                    <img src="{{ asset('assets/images/common/logo-icon.svg') }}" alt="Lexend">
                                    <span>lexend</span>
                                </a>
                            </div>
                        </div>
                        <div class="uc-navbar-center">
                            <ul class="uc-navbar-nav gap-3 xl:gap-5 d-none lg:d-flex fs-5 fw-medium" data-uc-scrollspy-nav="closest: li; offset: 40; scroll: true">
                                <li class="d-none">
                                    <a href="#overview">Overview</a>
                                </li>
                                <li><a href="#features">Features</a></li>
                                <li><a href="#how_it_works">How it works</a></li>
                                <li><a href="#pricing">Pricing</a></li>
                                <li><a href="#faq">FAQs</a></li>
                            </ul>
                        </div>
                        <div class="uc-navbar-right">
                            @if (Route::has('login'))
                            @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-sm btn-primary px-3 d-none lg:d-inline-flex"><span>Dashboard</span></a>
                            @else
                            <a href="{{ route('login') }}" class="fs-5 fw-medium text-none d-none lg:d-inline-flex"><span>Sign In</span></a>
                            @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-sm btn-primary px-3 d-none lg:d-inline-flex"><span>Register</span></a>
                            @endif
                            @endauth
                            @endif
                            <a class="d-block lg:d-none" href="#uc-menu-panel" data-uc-navbar-toggle-icon data-uc-toggle></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    @endif

    <!-- Header end -->

    <!-- Wrapper start -->
    <div id="wrapper" class="wrap">

        {{ $slot }}

    </div>

    <!-- Wrapper end -->

    <!-- Footer start -->
    @if($showFooter)
    <footer id="uc-footer" class="uc-footer panel overflow-hidden uc-dark">
        <div class="footer-outer pb-4 lg:pb-6 dark:bg-gray-800 dark:text-white m-2 rounded-2 lg:rounded-3">
            <div class="uc-footer-content pt-6 lg:pt-8">
                <div class="container xl:max-w-xl">
                    <div class="uc-footer-inner vstack gap-4 lg:gap-6 xl:gap-8">
                        <div class="uc-footer-widgets panel">
                            <div class="row child-cols-6 md:child-cols col-match g-4">
                                <div class="col-12 lg:col-6">
                                    <div class="panel vstack items-start gap-3 xl:gap-4 lg:max-w-1/2">
                                        <div>
                                            <a href="index.html" style="width: 140px">
                                                <img class="text-primary" src="../assets/images/common/logo-dark.svg" alt="{{ config('app.name') }}">
                                            </a>
                                            <p class="mt-2">{{ config('app.name') }} automatically creates, schedules, and posts Faceless videos for you, on auto-pilot. Each video is unique and customized to your topic.</p>
                                        </div>
                                        <!-- <div class="d-inline-block">
                                            <a href="#" class="hstack gap-1 text-none fw-medium">
                                                <i class="icon icon-1 unicon-earth-filled"></i>
                                                <span>English</span>
                                                <span data-uc-drop-parent-icon=""></span>
                                            </a>
                                            <div class="p-2 bg-white dark:bg-gray-700 shadow-xs rounded w-150px" data-uc-drop="mode: click; offset: 16; pos: bottom-center; boundary: !.uc-footer-widgets; animation: uc-animation-slide-top-small; duration: 150;">
                                                <ul class="nav-y gap-1 fw-medium rtl:items-end">
                                                    <li><a href="#en">English</a></li>
                                                    <li><a href="#ar">العربية</a></li>
                                                    <li><a href="#ch">中文</a></li>
                                                </ul>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div>
                                    <ul class="nav-y gap-2 fw-medium">
                                        <li class="fs-7 text-uppercase dark:text-gray-300">Company</li>
                                        <li><a href="#pricing">Pricing</a></li>
                                        <li><a href="#faq">FAQs</a></li>
                                        <li><a href="#">Affiliates</a></li>
                                        <li><a href="#">Contact Us</a></li>
                                    </ul>
                                </div>
                                <div>
                                    <ul class="nav-y gap-2 fw-medium">
                                        <li class="fs-7 text-uppercase dark:text-gray-300">Support</li>
                                        <li><a href="#how_it_works">FAQs</a></li>
                                        <li><a href="#features">Terms & Conditions</a></li>
                                        <li><a href="#key_features">Privacy Policy</a></li>
                                        <li><a href="#builder_elements">Google API Disclosure</a></li>
                                        <li><a href="#pricing">Articles</a></li>
                                    </ul>
                                </div>
                                <!-- <div class="d-none lg:d-block">
                                    <ul class="nav-y gap-2 fw-medium">
                                        <li class="fs-7 text-uppercase dark:text-gray-300">Resources</li>
                                        <li><a href="blog.html">Blog</a></li>
                                        <li><a href="#">Newsletter</a></li>
                                        <li><a href="#">Events</a></li>
                                        <li><a href="#">Help center</a></li>
                                        <li><a href="#">Tutorials</a></li>
                                        <li><a href="#">Support</a></li>
                                    </ul>
                                </div> -->
                            </div>
                        </div>
                        <div class="uc-footer-bottom panel vstack lg:hstack gap-4 justify-between text-center pt-4 lg:pt-6 border-top dark:text-white">
                            <p class="opacity-60">{{ config('app.name') }} © {{ date('Y') }}, All rights reserved.</p>
                            <ul class="nav-x justify-center gap-2 text-gray-300">
                                <li><a href="#"><i class="icon icon-2 unicon-logo-facebook"></i></a></li>
                                <li><a href="#"><i class="icon icon-2 unicon-logo-youtube"></i></a></li>
                                <li><a href="#"><i class="icon icon-2 unicon-logo-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @endif

    <!-- Footer end -->

    <!-- include jquery & bootstrap js -->
    <script defer src="../assets/js/libs/jquery.min.js"></script>
    <script defer src="../assets/js/libs/bootstrap.min.js"></script>

    <!-- include scripts -->
    <script defer src="../assets/js/libs/anime.min.js"></script>
    <script defer src="../assets/js/libs/swiper-bundle.min.js"></script>
    <script defer src="../assets/js/libs/scrollmagic.min.js"></script>
    <script defer src="../assets/js/helpers/data-attr-helper.js"></script>
    <script defer src="../assets/js/helpers/swiper-helper.js"></script>
    <script defer src="../assets/js/helpers/anime-helper.js"></script>
    <script defer src="../assets/js/helpers/anime-helper-defined-timelines.js"></script>
    <script defer src="../assets/js/uikit-components-bs.js"></script>

    <!-- include app script -->
    <script defer src="../assets/js/app.js"></script>

    <script>
        // Schema toggle via URL
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const getSchema = urlParams.get("schema");
        if (getSchema === "dark") {
            setDarkMode(1);
        } else if (getSchema === "light") {
            setDarkMode(0);
        }
    </script>
</body>

</html>