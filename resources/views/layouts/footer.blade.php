<!-- Footer Start -->
<div class="container-fluid footer bg-dark wow fadeIn" data-wow-delay=".3s">
    <div class="container pt-5 pb-4">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('index') }}">
                    <h2 class="text-white fw-bold d-block h1">Open<span class="text-secondary">Clusters</span> </h2>
                </a>
                <p class="mt-4 text-light">A leading provider of innovative IT solutions, dedicated to helping businesses achieve their goals through cutting-edge technology and exceptional service.</p>
                <div class="d-flex hightech-link">
                    <a href="" class="btn-light nav-fill btn btn-square rounded-circle me-2"><i class="fab fa-facebook-f text-primary"></i></a>
                    <a href="" class="btn-light nav-fill btn btn-square rounded-circle me-2"><i class="fab fa-twitter text-primary"></i></a>
                    <a href="" class="btn-light nav-fill btn btn-square rounded-circle me-2"><i class="fab fa-instagram text-primary"></i></a>
                    <a href="" class="btn-light nav-fill btn btn-square rounded-circle me-0"><i class="fab fa-linkedin-in text-primary"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="#" class="h3 text-secondary">Short Link</a>
                <div class="mt-4 d-flex flex-column short-link">
                    <a href="{{ route('aboutus') }}" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>About us</a>
                    <a href="{{ route('contactus') }}" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>Contact us</a>
                    <a href="{{ route('services') }}" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>Our Services</a>
                    <a href="{{ route('blogs') }}" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>Blogs</a>
                    <a href="{{ route('team') }}" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>Our Team</a>
                    <a href="{{ route('index') }}" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>Home</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="#" class="h3 text-secondary">Help Link</a>
                <div class="mt-4 d-flex flex-column help-link">
                    <a href="{{ route('services.automation') }}" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>Automation Services</a>
                    <a href="{{ route('services.itservice') }}" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>IT Services</a>
                    <a href="{{ route('services.itsolutions') }}" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>IT Solutions</a>
                    <a href="{{ route('services.softwaredevelopment') }}" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>Software Development</a>
                    <a href="{{ route('services.staffing') }}" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>Staffing</a>
                    <a href="{{ route('services.training') }}" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>Training</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="#" class="h3 text-secondary">Contact Us</a>
                <div class="text-white mt-4 d-flex flex-column contact-link">
                    <a href="#" class="pb-3 text-light border-bottom border-primary"><i class="fas fa-map-marker-alt text-secondary me-2"></i> 688 Costz Azul Imperial county CA</a>
                    <a href="tel:+17604120990" class="py-3 text-light border-bottom border-primary"><i class="fas fa-phone-alt text-secondary me-2"></i> +1 (760) 412-0990</a>
                    <a href="mailto:contact@theopenclusters.com" class="py-3 text-light border-bottom border-primary"><i class="fas fa-envelope text-secondary me-2"></i> contact@theopenclusters.com</a>
                </div>
            </div>
        </div>
        <hr class="text-light mt-5 mb-4">
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <span class="text-light"><a href="{{ route('index') }}" class="text-secondary"><i class="fas fa-copyright text-secondary me-2"></i>Open Clusters Systems</a>, All right reserved.</span>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="footer-menu">
                    <a href="{{ route('index') }}" class="text-white">Home</a>
                    <a href="{{ route('blogs') }}" class="text-white">Blogs</a>
                    <a href="{{ route('contactus') }}" class="text-white">Help</a>
                    <a href="{{ route('sitemap') }}" class="text-white">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Back to Top -->
<a href="#" class="btn btn-secondary btn-square rounded-circle back-to-top"><i class="fa fa-arrow-up text-white"></i></a>

<!-- JavaScript Libraries - Load only once -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('lib/wow/wow.min.js') }}"></script>
<script src="{{ asset('lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

<!-- Main Template Javascript -->
<script src="{{ asset('js/main.js') }}"></script>

<!-- Contact message scroll functionality -->
<script>
window.addEventListener('load', function() {
    var element = document.getElementById('contactmessage');
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
});
</script>
