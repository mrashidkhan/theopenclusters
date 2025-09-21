@extends('layouts.master')

@section('content')
<!-- 404 Error Start -->
<div class="container-fluid py-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="text-center">
                    <!-- 404 Number -->
                    <div class="mb-4">
                        <h1 class="display-1 fw-bold text-primary" style="font-size: 8rem;">404</h1>
                    </div>

                    <!-- Error Message -->
                    <div class="mb-4">
                        <h2 class="h1 text-dark mb-3">Oops! Page Not Found</h2>
                        <p class="lead text-muted mb-4">
                            The page you are looking for might have been removed, had its name changed,
                            or is temporarily unavailable.
                        </p>
                    </div>

                    <!-- Search Box -->
                    <div class="mb-5">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg"
                                           placeholder="Search our website..." id="search404">
                                    <button class="btn btn-primary btn-lg" type="button" onclick="search404()">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Navigation -->
                    <div class="row g-4 mb-5">
                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-home fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">Homepage</h5>
                                    <p class="card-text">Return to our homepage and explore our services</p>
                                    <a href="{{ route('index') }}" class="btn btn-outline-primary">Go Home</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-cogs fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">Our Services</h5>
                                    <p class="card-text">Discover our comprehensive IT solutions</p>
                                    <a href="{{ route('services') }}" class="btn btn-outline-primary">View Services</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-blog fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">Our Blog</h5>
                                    <p class="card-text">Read our latest insights and tech articles</p>
                                    <a href="{{ route('blogs') }}" class="btn btn-outline-primary">Read Blog</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">Contact Us</h5>
                                    <p class="card-text">Get in touch with our expert team</p>
                                    <a href="{{ route('contactus') }}" class="btn btn-outline-primary">Contact</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Popular Pages -->
                    <div class="bg-light rounded p-4 mb-4">
                        <h4 class="text-primary mb-3">Popular Pages</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <a href="{{ route('aboutus') }}" class="text-decoration-none">
                                            <i class="fas fa-angle-right text-secondary me-2"></i>About Us
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a href="{{ route('services.automation') }}" class="text-decoration-none">
                                            <i class="fas fa-angle-right text-secondary me-2"></i>Automation Services
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a href="{{ route('services.softwaredevelopment') }}" class="text-decoration-none">
                                            <i class="fas fa-angle-right text-secondary me-2"></i>Software Development
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <a href="{{ route('clients') }}" class="text-decoration-none">
                                            <i class="fas fa-angle-right text-secondary me-2"></i>Our Clients
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a href="{{ route('team') }}" class="text-decoration-none">
                                            <i class="fas fa-angle-right text-secondary me-2"></i>Our Team
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a href="{{ route('services.training') }}" class="text-decoration-none">
                                            <i class="fas fa-angle-right text-secondary me-2"></i>Training Services
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="bg-primary text-white rounded p-4">
                                <h5 class="mb-3">Need Help?</h5>
                                <p class="mb-3">If you can't find what you're looking for, our team is here to help!</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="tel:+17604120990" class="btn btn-light">
                                        <i class="fas fa-phone me-2"></i>Call Us
                                    </a>
                                    <a href="mailto:contact@theopenclusters.com" class="btn btn-secondary">
                                        <i class="fas fa-envelope me-2"></i>Email Us
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
<!-- 404 Error End -->

<script>
function search404() {
    const searchTerm = document.getElementById('search404').value.trim();
    if (searchTerm) {
        // You can customize this search functionality
        // For now, it redirects to Google site search
        window.open(`https://www.google.com/search?q=site:theopenclusters.com ${encodeURIComponent(searchTerm)}`, '_blank');
    }
}

// Allow Enter key to trigger search
document.getElementById('search404').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        search404();
    }
});

// Track 404 errors in Google Analytics if available
if (typeof gtag !== 'undefined') {
    gtag('event', 'page_view', {
        page_title: '404 - Page Not Found',
        page_location: window.location.href,
        custom_map: {'custom_parameter_1': 'error_page'}
    });
}
</script>
@endsection
