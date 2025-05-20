<!DOCTYPE html>
<html lang="en">
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
    <link rel="stylesheet" href="{{asset("css/userExterior.css")}}">
    <!-- Add FontAwesome for star icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    @yield("stylelink")
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{asset("css/responsive.css")}}">

    <style>
        #notification {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            z-index: 9999;
        }
    </style>
</head>
<body>
<header class="navbar-container">
    <div class="navbar-content">
        <!-- Logo -->
        <div class="navbar-logo">
            <img src="{{asset("images/logo-white.svg")}}" alt="Shipex Logo" />
{{--            <span class="logo-text"><span>Shipex</span></span>--}}
        </div>

        <!-- Navbar Menu -->
        <nav class="navbar-menu">
            <ul>
                <li><a href="{{route('indexUser')}}" class="">Home</a></li>
                <li>
                    <a href="{{asset("DeliveryForm")}}">Create Delivery <span style="font-size: 15px">+</span></a>
                </li>
                <li>
                    <a href="{{asset("PendingDeliveries")}}">Pending Deliveries</a>
                </li>
                <li>
                    <a href="{{asset("calendar")}}">Calendar</a>
                </li>

                <li><a
                        @if(Auth::check())
                            href="{{route("BrowseDrivers")}}"
                        @else
                            href="{{route("login")}}"
                        @endif
                    >Drivers
                    </a></li>
                <li >
                    <a href="{{route('AboutUsSection')}}">About Us</a>
                </li>
            </ul>
        </nav>

        <!-- Social Icons -->
        <div class="navbar-social">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-x-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
       <!-- Check if the user is logged in -->
@if(Auth::check())
            <style>
                .custom-logout:hover {
                    background-color: red !important;
                }
            </style>
            <a style="color: white;" class="btn btn-danger custom-logout" href="{{route('logout')}}">Log Out</a>
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
</header>

<div id="notification">
</div>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
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
@yield("content")


<!-- footer -->
<footer class="site-footer pbmit-bg-color-secondary">
    <div class="pbmit-footer-big-area-wrapper">

{{--        <div class="pbmit-footer-widget-area">--}}
{{--            <div class="container">--}}
{{--                <div class="row">--}}
{{--                    <div class="pbmit-footer-widget-col-1 col-md-4">--}}
{{--                        <aside class="widget">--}}
{{--                            <div class="pbmit-footer-logo">--}}
{{--                                <img src="{{asset("images/footer-logo.svg")}}" class="img-fluid" alt="">--}}
{{--                            </div><br>--}}
{{--                            <ul class="pbmit-social-links">--}}
{{--                                <li class="pbmit-social-li pbmit-social-facebook">--}}
{{--                                    <a title="Facebook" href="#" target="_blank">--}}
{{--                                        <span><i class="pbmit-base-icon-facebook-f"></i></span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="pbmit-social-li pbmit-social-twitter">--}}
{{--                                    <a title="Twitter" href="#" target="_blank">--}}
{{--                                        <span><i class="pbmit-base-icon-twitter-2"></i></span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="pbmit-social-li pbmit-social-linkedin">--}}
{{--                                    <a title="LinkedIn" href="#" target="_blank">--}}
{{--                                        <span><i class="pbmit-base-icon-linkedin-in"></i></span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="pbmit-social-li pbmit-social-instagram">--}}
{{--                                    <a title="Instagram" href="#" target="_blank">--}}
{{--                                        <span><i class="pbmit-base-icon-instagram"></i></span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </aside>--}}
{{--                    </div>--}}
{{--                    <div class="pbmit-footer-widget-col-2 col-md-4">--}}
{{--                        <aside class="widget">--}}
{{--                            <h2 class="widget-title">Say Hello</h2>--}}
{{--                            <div class="pbmit-contact-widget-lines">--}}
{{--                                <div class="pbmit-contact-widget-line pbmit-base-icon-phone">+1-800123-456-789</div>--}}
{{--                                <div class="pbmit-contact-widget-line pbmit-base-icon-email"><a href="https://shipex-demo.pbminfotech.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="630d0c4e1106130f1a2313010e0a0d050c1706000b4d000c0e">[email&#160;protected]</a></div>--}}
{{--                            </div>--}}
{{--                        </aside>--}}
{{--                    </div>--}}
{{--                    <div class="pbmit-footer-widget-col-3 col-md-2">--}}
{{--                        <aside class="widget">--}}
{{--                            <h2 class="widget-title">Useful Link</h2>--}}
{{--                            <ul class="menu">--}}
{{--                                <li><a href="{{asset("about-us.html")}}">About</a></li>--}}
{{--                                <li><a href="{{asset("services.html")}}">Our Service</a></li>--}}
{{--                                <li><a href="{{asset("our-history.html")}}">Company</a></li>--}}
{{--                                <li><a href="{{asset("blog-classic.html")}}">News & Media</a></li>--}}
{{--                                <li><a href="{{asset("our-team.html")}}">Team</a></li>--}}
{{--                            </ul>--}}
{{--                        </aside>--}}
{{--                    </div>--}}
{{--                    <div class="pbmit-footer-widget-col-4 col-md-2">--}}
{{--                        <aside class="widget widget_text">--}}
{{--                            <h2 class="widget-title">Our Services</h2>--}}
{{--                            <ul class="menu">--}}
{{--                                <li><a >Logistics</a></li>--}}
{{--                                <li><a >Manufacturing</a></li>--}}
{{--                                <li><a >Production</a></li>--}}
{{--                                <li><a >Transportation</a></li>--}}
{{--                                <li><a >Warehouse</a></li>--}}
{{--                            </ul>--}}
{{--                        </aside>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
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
</body>
</html>
