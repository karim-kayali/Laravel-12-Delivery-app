<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Shipex Demo1 – Transport and Logistics HTML Template</title>
    <meta name="robots" content="noindex, follow">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset("images/fevicon.png")}}">
    <!-- CSS
        ============================================ -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset("css/bootstrap.min.css")}}">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="{{asset("css/fontawesome.css")}}">
    <!-- Flaticon -->
    <link rel="stylesheet" href="{{asset("css/flaticon.css")}}">
    <!-- Base Icons -->
    <link rel="stylesheet" href="{{asset("css/pbminfotech-base-icons.css")}}">
    <!-- Themify Icons -->
    <link rel="stylesheet" href="{{asset("css/themify-icons.css")}}">
    <!-- Slick -->
    <link rel="stylesheet" href="{{asset("css/swiper.min.css")}}">
    <!-- Magnific -->
    <link rel="stylesheet" href="{{asset("css/magnific-popup.css")}}">
    <!-- AOS -->
    <link rel="stylesheet" href="{{asset("css/aos.css")}}">
    <!-- Shortcode CSS -->
    <link rel="stylesheet" href="{{asset("css/shortcode.css")}}">
    <!-- Base CSS -->
    <link rel="stylesheet" href="{{asset("css/base.css")}}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset("css/style.css")}}">
    @yield("stylelink")
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{asset("css/responsive.css")}}">
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

</head>
<body>
<div id="notification" style="
        display: none;
        position: fixed;
        top: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        z-index: 9999;">
</div>
<!-- page wrapper -->
<div class="page-wrapper" id="page">

    <!-- Header Main Area -->
    <header class="site-header header-style-1">
        <div class="pbmit-header-overlay">
            <div class="pbmit-main-header-area">
                <div class="container-fluid">
                    <div class="pbmit-header-content d-flex justify-content-between align-items-center">
                        <div class="pbmit-logo-menuarea d-flex justify-content-between align-items-center">
                            <div class="site-branding">
                                <h1 class="site-title">
                                    <a href="{{asset("index-2.html")}}">
                                        <img class="logo-img" src="{{asset("images/logo-white.svg")}}" alt="Shipex">
                                    </a>
                                </h1>
                            </div>
                            <div class="site-navigation">
                                <nav class="main-menu navbar-expand-xl navbar-light" >
                                    <div class="navbar-header">
                                        <!-- Toggle Button -->
                                        <button class="navbar-toggler" type="button">
                                            <i class="pbmit-base-icon-menu-1"></i>
                                        </button>
                                    </div>
                                    <div class="pbmit-mobile-menu-bg"></div>
                                    <div class="collapse navbar-collapse clearfix show" id="pbmit-menu">
                                        <div class="pbmit-menu-wrap navpar" >
												<span class="closepanel">
													<svg class="qodef-svg--close qodef-m" xmlns="http://www.w3.org/2000/svg" width="20.163" height="20.163" viewBox="0 0 26.163 26.163">
														<rect width="36" height="1" transform="translate(0.707) rotate(45)"></rect>
														<rect width="36" height="1" transform="translate(0 25.456) rotate(-45)"></rect>
													</svg>
												</span>
                                            <ul class="navigation clearfix" >
                                                {{--                                                want a dropdown: add "dropdown" in li class--}}
                                                <li class="active">
                                                    <a href="{{route('indexUser')}}">Home</a>
                                                </li>
                                                <li>
                                                    <a
                                                        @if(Auth::check())
                                                            href="{{route("DeliveryForm")}}"

                                                    @else
                                                        href="{{route("login")}}"
                                                        @endif


                                                    >Create Delivery <span style="font-size: 15px">+</span></a>
                                                </li>
                                                <li>
                                                    <a
                                                        @if(Auth::check())

                                                            href="{{route("PendingDeliveries")}}"

                                                       @else
                                                           href="{{route("login")}}"
                                                        @endif
                                                    >Pending Deliveries</a>
                                                </li>
                                                <li>

                                                    <a
                                                        @if(Auth::check())
                                                            href="{{asset("calendar")}}"
                                                        @else
                                                            href="{{route("login")}}"
                                                        @endif
                                                    >Calendar</a>
                                                </li>
{{--                                                <li class="dropdown">--}}
{{--                                                    <a href="#">Services</a>--}}
{{--                                                    <ul>--}}
{{--                                                        <li><a href="{{asset("services.html")}}">Create Delivery <span style="font-size: 15px">+</span></a></li>--}}
{{--                                                        <li><a href="{{asset("service-details.html")}}">Service Details</a></li>--}}
{{--                                                    </ul>--}}
{{--                                                </li>--}}
{{--                                                <li class="dropdown">--}}
{{--                                                    <a href="#">More</a>--}}
{{--                                                    <ul>--}}
{{--                                                        <li><a href="{{asset("about-us.html")}}">About Us</a></li>--}}
{{--                                                        <li><a href="{{asset("our-history.html")}}">Our History</a></li>--}}
{{--                                                        <li><a href="{{asset("our-team.html")}}">Our Team</a></li>--}}
{{--                                                    </ul>--}}
{{--                                                </li>--}}
                                                <li><a
                                                        @if(Auth::check())
                                                            href="{{route("BrowseDrivers")}}"
                                                        @else
                                                            href="{{route("login")}}"
                                                        @endif
                                                    >Drivers</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('AboutUsSection')}}">About Us</a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <div class="pbmit-right-box d-flex align-items-center">
{{--                            <div class="social-links-wrapper">--}}
{{--                                <ul class="pbmit-social-links">--}}
{{--                                    <li class="pbmit-social-li pbmit-social-facebook">--}}
{{--                                        <a title="Facebook" href="#" target="_blank">--}}
{{--                                            <span><i class="pbmit-base-icon-facebook-f"></i></span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="pbmit-social-li pbmit-social-twitter">--}}
{{--                                        <a title="Twitter" href="#" target="_blank">--}}
{{--                                            <span><i class="pbmit-base-icon-twitter-2"></i></span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="pbmit-social-li pbmit-social-linkedin">--}}
{{--                                        <a title="LinkedIn" href="#" target="_blank">--}}
{{--                                            <span><i class="pbmit-base-icon-linkedin-in"></i></span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="pbmit-social-li pbmit-social-instagram">--}}
{{--                                        <a title="Instagram" href="#" target="_blank">--}}
{{--                                            <span><i class="pbmit-base-icon-instagram"></i></span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
                            {{--                            <div class="pbmit-header-search-btn">--}}
                            {{--                                <a href="#" title="Search">--}}
                            {{--                                    <i class="pbmit-base-icon-search-1"></i>--}}
                            {{--                                </a>--}}
                            {{--                            </div>--}}
                            <div class="pbmit-header-button2">
                               <!-- Check if the user is logged in -->
<!-- Check if the user is logged in -->
@if(Auth::check())
                                    <style>
                                        .custom-logout:hover {
                                            background-color: red !important;
                                        }
                                    </style>
        <a style="color: white; margin-right: 30px" class="btn btn-danger custom-logout" href="{{route('logout')}}">Log Out</a>

    <!-- Add a button to show the user's info (or redirect to the user profile) -->
    <a class="pbmit-btn pbmit-btn-white" href="{{ route('displayUserProfile', ['id' => Auth::user()->id]) }}">
        <span class="pbmit-button-content-wrapper">
            <span class="pbmit-button-text"> Welcome, <b class="userName">{{ Auth::user()->userName }}</b></span>
        </span>
    </a>

@else
    <!-- Display login button if not logged in -->
    <a class="pbmit-btn pbmit-btn-white" href="{{ route('login') }}">
        <span class="pbmit-button-content-wrapper">
            <span class="pbmit-button-text">Login</span>
        </span>
    </a>
@endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pbmit-slider-area pbmit-slider-one">
            <div class="swiper-slider" data-autoplay="true" data-loop="true" data-dots="true" data-arrows="false" data-columns="1" data-margin="0" data-effect="fade">
                <div class="swiper-wrapper">
                    <!-- Slide1 -->
                    <div class="swiper-slide">
                        <div class="pbmit-slider-item">
                            <div class="pbmit-slider-bg" style="background-image: url({{asset("images/banner-slider-img/demo-01-slide-1.jpg")}});"></div>
                            <div class="container">
                                <div class="pbmit-slider-content">
                                    <div class="row align-items-end g-0">
                                        <div class="col-md-12 col-lg-8">
                                            <h5 class="pbmit-sub-title transform-right transform-delay-1"><span>Reliable Transport for Every Heavy-Duty Need</span></h5>
                                            <h2 class="pbmit-title transform-left-1 transform-delay-2"><span><br>our fleet of trucks and minivans ensures your orders move efficiently, no matter the size.</span></h2>
                                        </div>
                                        <div class="col-md-12 col-lg-4">
                                            <div class="pbmit-slider-right-content">
                                                <div class="pbmit-desc transform-center transform-delay-3">
                                                    Streamlined for capacity and speed, <br> our website provides solutions that guarantee timely deliveries with the flexibility and reliability your business deserves. <br>
                                                </div>
                                                <div class="pbmit-button transform-bottom transform-delay-4">
                                                    <a class="pbmit-btn" href="{{asset("services.html")}}">
															<span class="pbmit-button-content-wrapper">
																<span class="pbmit-button-text">our services</span>
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
                    <!-- Slide2 -->
                    <div class="swiper-slide">
                        <div class="pbmit-slider-item">
                            <div class="pbmit-slider-bg"
                                 style="background-image: url({{ asset('images/2016_volkswagen_caddy_1_1600x1200.jpg') }});
            filter: grayscale(60%) brightness(90%);">
                            </div>
                            <div class="container">
                                <div class="pbmit-slider-content">
                                    <div class="row align-items-end">
                                        <div class="col-md-12 col-lg-8 g-0">
                                            <h5 class="pbmit-sub-title transform-right transform-delay-1"><span>Everyday Deliveries, Handled with Care</span></h5>
                                            <h2 class="pbmit-title transform-left-1 transform-delay-2"><span>Our car delivery service is perfect for <br> medium-sized orders, fast, secure, and ideal for urban and suburban routes.</span></h2>
                                        </div>
                                        <div class="col-md-12 col-lg-4">
                                            <div class="pbmit-slider-right-content">
                                                <div class="pbmit-desc transform-center transform-delay-3">
                                                    Count on us for efficient, <br>door-to-door delivery solutions that balance speed, convenience, and professionalism every step of the way.<br>
                                                </div>
                                                <div class="pbmit-button transform-bottom transform-delay-4">
                                                    <a class="pbmit-btn" href="{{asset("services.html")}}">
															<span class="pbmit-button-content-wrapper">
																<span class="pbmit-button-text">our services</span>
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
                    <!-- Slide3 -->
                    <div class="swiper-slide">
                        <div class="pbmit-slider-item">
                            <div class="pbmit-slider-bg" style="background-image: url({{asset("images/vecteezy_ai-generated-fast-delivery-advertisment-background-with-copy_37245929.jpg")}});filter: grayscale(60%) brightness(90%);"></div>
                            <div class="container">
                                <div class="pbmit-slider-content">
                                    <div class="row align-items-end">
                                        <div class="col-md-12 col-lg-8">
                                            <h5 class="pbmit-sub-title transform-right transform-delay-1"><span>Lightning-Fast Deliveries, Right to Your Door</span></h5>
                                            <h2 class="pbmit-title transform-left-1 transform-delay-2"><span>Our motorcycle fleet zips through traffic to <br>deliver small parcels and urgent orders with unmatched speed and agility.<br> </span></h2>
                                        </div>
                                        <div class="col-md-12 col-lg-4">
                                            <div class="pbmit-slider-right-content">
                                                <div class="pbmit-desc transform-center transform-delay-3">
                                                    Ideal for same-day deliveries and tight deadlines, <br>our two-wheelers ensure your items arrive on time,every time.<br>
                                                </div>
                                                <div class="pbmit-button transform-bottom transform-delay-4">
                                                    <a class="pbmit-btn" href="{{asset("services.html")}}">
															<span class="pbmit-button-content-wrapper">
																<span class="pbmit-button-text">our services</span>
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
            </div>
        </div>
    </header>
    <!-- Header Main Area End Here -->

    @yield("content")
    {{-- Global Pusher Script --}}
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            encrypted: true
        });

        var channel = pusher.subscribe('success-channel');

        channel.bind('success-event', function(data) {
            showNotification(data.message);
        });

        function showNotification(message) {
            const notification = document.getElementById('notification');
            if (!notification) return;
            notification.innerText = message;
            notification.style.display = 'block';

            setTimeout(() => {
                notification.style.display = 'none';
            }, 4000);
        }
        function sendNotification() {
            fetch('/trigger-success-event');
        }
    </script>
    <div id="notification" style="display: none; position: fixed; top: 20px; right: 20px; background-color: #4caf50; color: white; padding: 10px; border-radius: 5px; z-index: 9999;">
    </div>

    <!-- footer -->
    <footer class="site-footer pbmit-bg-color-secondary">
        <div class="pbmit-footer-big-area-wrapper">
            <div class="pbmit-footer-big-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-12 col-xl-6 pbmit-footer-left">
                            <h3>Subscribe for latest <br> updates & insights</h3>
                        </div>
                        <div class="col-md-12 col-xl-6">
                            <form>
                                <div class="pbmit-footer-newsletter">
                                    <div class="pbmit-news-wrap">
                                        <input type="email" class="form-control" name="EMAIL" placeholder="Enter Your Email Address">
                                        <button class="pbmit-btn">
												<span class="pbmit-button-content-wrapper">
													<span class="pbmit-button-text">Subscribe Now</span>
												</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pbmit-footer-widget-area">
                <div class="container">
                    <div class="row">
                        <div class="pbmit-footer-widget-col-1 col-md-4">
                            <aside class="widget">
                                <div class="pbmit-footer-logo">
                                    <img src="{{asset("images/footer-logo.svg")}}" class="img-fluid" alt="">
                                </div><br>
                                <ul class="pbmit-social-links">
                                    <li class="pbmit-social-li pbmit-social-facebook">
                                        <a title="Facebook" href="#" target="_blank">
                                            <span><i class="pbmit-base-icon-facebook-f"></i></span>
                                        </a>
                                    </li>
                                    <li class="pbmit-social-li pbmit-social-twitter">
                                        <a title="Twitter" href="#" target="_blank">
                                            <span><i class="pbmit-base-icon-twitter-2"></i></span>
                                        </a>
                                    </li>
                                    <li class="pbmit-social-li pbmit-social-linkedin">
                                        <a title="LinkedIn" href="#" target="_blank">
                                            <span><i class="pbmit-base-icon-linkedin-in"></i></span>
                                        </a>
                                    </li>
                                    <li class="pbmit-social-li pbmit-social-instagram">
                                        <a title="Instagram" href="#" target="_blank">
                                            <span><i class="pbmit-base-icon-instagram"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </aside>
                        </div>
                        <div class="pbmit-footer-widget-col-2 col-md-4">
                            <aside class="widget">
                                <h2 class="widget-title">Say Hello</h2>
                                <div class="pbmit-contact-widget-lines">
                                    <div class="pbmit-contact-widget-line pbmit-base-icon-phone">+1-800123-456-789</div>
                                    <div class="pbmit-contact-widget-line pbmit-base-icon-email"><a href="https://shipex-demo.pbminfotech.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="630d0c4e1106130f1a2313010e0a0d050c1706000b4d000c0e">[email&#160;protected]</a></div>
                                </div>
                            </aside>
                        </div>
                        <div class="pbmit-footer-widget-col-3 col-md-2">
                            <aside class="widget">
                                <h2 class="widget-title">Useful Link</h2>
                                <ul class="menu">
                                    <li><a href="{{asset("about-us.html")}}">About</a></li>
                                    <li><a href="{{asset("services.html")}}">Our Service</a></li>
                                    <li><a href="{{asset("our-history.html")}}">Company</a></li>
                                    <li><a href="{{asset("blog-classic.html")}}">News & Media</a></li>
                                    <li><a href="{{asset("our-team.html")}}">Team</a></li>
                                </ul>
                            </aside>
                        </div>
                        <div class="pbmit-footer-widget-col-4 col-md-2">
                            <aside class="widget widget_text">
                                <h2 class="widget-title">Our Services</h2>
                                <ul class="menu">
                                    <li><a >Logistics</a></li>
                                    <li><a >Manufacturing</a></li>
                                    <li><a >Production</a></li>
                                    <li><a >Transportation</a></li>
                                    <li><a >Warehouse</a></li>
                                </ul>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pbmit-footer-text-area">
                <div class="container">
                    <div class="pbmit-footer-text-inner">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pbmit-footer-copyright-text-area">
                                    Copyright © 2025 <a href="#">Shipex Demo1</a>, All Rights Reserved.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer End -->

</div>
<!-- page wrapper End -->

<!-- Scroll To Top -->
<div class="pbmit-backtotop">
    <div class="pbmit-arrow">
        <i class="pbmit-base-icon-plane"></i>
    </div>
    <div class="pbmit-hover-arrow">
        <i class="pbmit-base-icon-plane"></i>
    </div>
</div>
<!-- Scroll To Top End -->

<!-- JS
    ============================================ -->
<!-- jQuery JS -->
<script data-cfasync="false" src="{{asset("../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js")}}"></script><script src="{{asset("js/jquery.min.js")}}"></script>
<!-- Popper JS -->
<script src="{{asset("js/popper.min.js")}}"></script>
<!-- Bootstrap JS -->
<script src="{{asset("js/bootstrap.min.js")}}"></script>
<!-- jquery Waypoints JS -->
<script src="{{asset("js/jquery.waypoints.min.js")}}"></script>
<!-- jquery Appear JS -->
<script src="{{asset("js/jquery.appear.js")}}"></script>
<!-- Numinate JS -->
<script src="{{asset("js/numinate.min.js")}}"></script>
<!-- Slick JS -->
<script src="{{asset("js/swiper.min.js")}}"></script>
<!-- Magnific JS -->
<script src="{{asset("js/jquery.magnific-popup.min.js")}}"></script>
<!-- Circle Progress JS -->
<script src="{{asset("js/circle-progress.js")}}"></script>
<!-- countdown JS -->
<script src="{{asset("js/jquery.countdown.min.js")}}"></script>
<!-- AOS -->
<script src="{{asset("js/aos.js")}}"></script>
<!-- GSAP -->
<script src='{{asset("js/gsap.js")}}'></script>
<!-- Scroll Trigger -->
<script src='{{asset("js/ScrollTrigger.js")}}'></script>
<!-- Split Text -->
<script src='{{asset("js/SplitText.js")}}'></script>
<!-- Theia Sticky Sidebar JS -->
<script src='{{asset("js/theia-sticky-sidebar.js")}}'></script>
<!-- GSAP Animation -->
<script src='{{asset("js/gsap-animation.js")}}'></script>
<!-- Form Validator -->
<script src="{{asset("js/jquery-validate/jquery.validate.min.js")}}"></script>
<!-- Scripts JS -->
<script src="{{asset("js/scripts.js")}}"></script>

{{--<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9377af52ec894329',t:'MTc0NTg1NTEwNy4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='../cdn-cgi/challenge-platform/h/g/scripts/jsd/44e6f86df4dc/maind41d.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"9377af52ec894329","version":"2025.4.0-1-g37f21b1","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"125856bf84ab44059737e93b01aa0fef","b":1}' crossorigin="anonymous"></script>--}}
</body>

</html>
