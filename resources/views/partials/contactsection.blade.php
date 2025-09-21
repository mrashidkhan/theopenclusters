<!-- Contact Start -->
<div class="container-fluid py-5 mb-5">
    <div class="container">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
            <h5 class="text-primary">Get In Touch</h5>
            @if(Request::is('contactus'))
                <h1 class="mb-3">Contact for any query</h1>
            @else
                <h2 class="h1 mb-3">Contact for any query</h1>
            @endif
            <p class="mb-2">Have a question, comment, or need assistance? Feel free to reach out to our team at Open Clusters Systems. We're committed to providing prompt and helpful responses to all inquiries.
                Simply fill out the form below, and we'll get back to you as soon as possible.</p>
        </div>
        <div class="contact-detail position-relative p-5">
            <div class="row g-5 mb-5 justify-content-center">
                <div class="col-xl-4 col-lg-6 wow fadeIn" data-wow-delay=".3s">
                    <div class="d-flex bg-light p-3 rounded">
                        <div class="flex-shrink-0 btn-square bg-secondary rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fas fa-map-marker-alt text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="text-primary">Address</h4>
                            <a href="https://goo.gl/maps/Zd4BCynmTb98ivUJ6" target="_blank" class="h5">Dallas</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 wow fadeIn" data-wow-delay=".5s">
                    <div class="d-flex bg-light p-3 rounded">
                        <div class="flex-shrink-0 btn-square bg-secondary rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fa fa-phone text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="text-primary">Call Us</h4>
                            <a class="h5" href="tel:+12146796818" target="_blank">+1 (214) 251-8581</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 wow fadeIn" data-wow-delay=".7s">
                    <div class="d-flex bg-light p-3 rounded">
                        <div class="flex-shrink-0 btn-square bg-secondary rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fa fa-envelope text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="text-primary">Email Us</h4>
                            <a class="h5" href="mailto:contact@theopenclusters.com" target="_blank">contact@theopenclusters.com</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay=".3s">
                    <div class="p-5 h-100 rounded contact-map">
                        <iframe class="rounded w-100 h-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3349.510950734504!2d-96.88844692562644!3d32.91109617712421!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x864c270017dcd47f%3A0x4a31ea28e07b500a!2sHitech%20Network%20Solutions!5e0!3m2!1sen!2s!4v1724795293929!5m2!1sen!2s" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                        {{-- <iframe class="rounded w-100 h-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13398.014490661824!2d-96.9042826473146!3d32.91128985883594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x864c2798885e69c3%3A0x84fe2fe3705eda19!2sMo-labs%20Media!5e0!3m2!1sen!2s!4v1724499131791!5m2!1sen!2s" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay=".5s">
                    <div class="p-5 rounded contact-form">
                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <input type="text" class="form-control border-0 py-3" name="name" placeholder="Your Name" required>
                            </div>
                            <div class="mb-4">
                                <input type="email" class="form-control border-0 py-3" name="email" placeholder="Your Email" required>
                            </div>
                            <div class="mb-4">
                                <input type="text" class="form-control border-0 py-3" name="subject" placeholder="Subject" required>
                            </div>
                            <div class="mb-4">
                                <textarea class="w-100 form-control border-0 py-3" name="message" rows="6" cols="10" placeholder="Message" required></textarea>
                            </div>
                            <div class="text-start">
                                <button class="btn bg-primary text-white py-3 px-5" type="submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                    @if (session('info'))
                            <br><br>
                            <div id="contactmessage" class="alert alert-success">

                                {{ session('info') }}
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->
