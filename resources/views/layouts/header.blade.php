<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PLRPMQWQ');</script>
<!-- End Google Tag Manager -->

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

    <!-- Dynamic Meta Tags -->
    <meta name="description" content="{{ isset($metaTags) ? $metaTags['description'] : 'Open Clusters Systems: Empowering businesses with cutting-edge IT solutions tailored to your specific needs.' }}">
    <meta name="keywords" content="{{ isset($metaTags) ? $metaTags['keywords'] : 'Application designing, IT Solutions, IT, Automation, Software, Digital Marketing' }}">
    <meta name="author" content="{{ isset($metaTags) ? $metaTags['author'] : 'Open Clusters Systems' }}">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ isset($metaTags) ? $metaTags['title'] : 'Open Clusters Systems' }}" />
    <meta property="og:type" content="{{ isset($metaTags) ? $metaTags['type'] : 'website' }}" />
    <meta property="og:description" content="{{ isset($metaTags) ? $metaTags['description'] : 'Open Clusters Systems: Empowering businesses with cutting-edge IT solutions tailored to your specific needs.' }}" />
    <meta property="og:image" content="{{ isset($metaTags) ? $metaTags['image'] : asset('img/logo.png') }}" />
    <meta property="og:url" content="{{ isset($metaTags) ? $metaTags['url'] : request()->url() }}" />
    <meta property="og:site_name" content="{{ isset($metaTags) ? $metaTags['site_name'] : 'Open Clusters Systems' }}" />

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ isset($metaTags) ? $metaTags['title'] : 'Open Clusters Systems' }}">
    <meta name="twitter:description" content="{{ isset($metaTags) ? $metaTags['description'] : 'Open Clusters Systems: Empowering businesses with cutting-edge IT solutions tailored to your specific needs.' }}">
    <meta name="twitter:image" content="{{ isset($metaTags) ? $metaTags['image'] : asset('img/favicon.png') }}">

    @if(isset($metaTags['canonical']))
    <link rel="canonical" href="{{ $metaTags['canonical'] }}">
    @endif

    <!-- Favicon and touch Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('img/favicon_io/site.webmanifest') }}">

    <!-- Page Title -->
    <title>{{ isset($metaTags) ? $metaTags['title'] : 'Open Clusters Systems' }}</title>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Saira:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Structured Data for SEO -->
    @if(isset($metaTags['schema']))
    <script type="application/ld+json">
    {!! json_encode($metaTags['schema']) !!}
    </script>
    @endif


</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    <div class="container-fluid bg-dark py-2 d-none d-md-flex">
        <div class="container">
            <div class="d-flex justify-content-between topbar">
                <div class="top-info">
                    <small class="me-3 text-white-50"><a href="#"><i
                                class="fas fa-map-marker-alt me-2 text-secondary"></i></a>California</small>
                    <small class="me-3 text-white-50"><a href="#"><i
                                class="fas fa-envelope me-2 text-secondary"></i></a>contact@theopenclusters.com</small>
                </div>
                <div id="note" class="text-secondary d-none d-xl-flex"><small>Note : We help you to Grow your
                        Business</small></div>
                <div class="top-link">
                    <a href="" class="bg-light nav-fill btn btn-sm-square rounded-circle"><i
                            class="fab fa-facebook-f text-primary"></i></a>
                    <a href="" class="bg-light nav-fill btn btn-sm-square rounded-circle"><i
                            class="fab fa-twitter text-primary"></i></a>
                    <a href="" class="bg-light nav-fill btn btn-sm-square rounded-circle"><i
                            class="fab fa-instagram text-primary"></i></a>
                    <a href="" class="bg-light nav-fill btn btn-sm-square rounded-circle me-0"><i
                            class="fab fa-linkedin-in text-primary"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid bg-primary">
        <div class="container">
            <nav class="navbar navbar-dark navbar-expand-lg py-0">
                <a href="{{ route('index') }}" class="navbar-brand">
                    <h1 class="text-white fw-bold d-block">Open<span class="text-secondary">Clusters</span> </h1>
                </a>
                <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse bg-transparent" id="navbarCollapse">
                    <div class="navbar-nav ms-auto mx-xl-auto p-0">
                        <a href="{{ route('index') }}"
                            class="nav-item nav-link {{ Request::is('/') ? 'active text-secondary' : '' }}">Home</a>
                        <a href="{{ route('aboutus') }}"
                            class="nav-item nav-link {{ Request::is('aboutus') ? 'active text-secondary' : '' }}">Aboutus</a>
                        <a href="{{ route('services') }}"
                            class="nav-item nav-link {{ Request::is('services*') ? 'active text-secondary' : '' }}">Services</a>
                        <a href="{{ route('clients') }}"
                            class="nav-item nav-link {{ Request::is('clients') ? 'active text-secondary' : '' }}"> Clients</a>

                        <a href="{{ route('blogs') }}"
                            class="nav-item nav-link {{ Request::is('blogs') ? 'active text-secondary' : '' }}">
                            Blogs</a>
                        <a href="{{ route('contactus') }}"
                            class="nav-item nav-link {{ Request::is('contactus') ? 'active text-secondary' : '' }}">Contactus</a>
                    </div>
                </div>
                <div class="d-none d-xl-flex flex-shirink-0">
                    <div id="phone-tada" class="d-flex align-items-center justify-content-center me-4">
                        <a href="tel:+923333284252" class="position-relative animated tada infinite">
                            <i class="fa fa-phone-alt text-white fa-2x"></i>
                            <div class="position-absolute" style="top: -7px; left: 20px;">
                                <span><i class="fa fa-comment-dots text-secondary"></i></span>
                            </div>
                        </a>
                    </div>
                    <div class="d-flex flex-column pe-4 border-end">
                        <span class="text-white-50">Have any questions?</span>
                        <span class="text-secondary">Call: +1 (760) 412-0990</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center ms-4 ">
                        <a href="#"><i class="bi bi-search text-white fa-2x"></i> </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->
