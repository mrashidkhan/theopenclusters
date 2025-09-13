<!-- Blog Start -->
<div class="container-fluid blog py-5 mb-5">
    <div class="container">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
            <h5 class="text-primary">Our Blog</h5>
            <h1>Latest Blog & News</h1>
        </div>
        <div class="row g-5 justify-content-center">
            @php
                // Featured blogs for homepage - limit to 3 posts
                $featuredBlogs = [
                    [
                        'slug' => 'modern-web-design-trends-2024',
                        'title' => 'Modern Web Design Trends for 2024',
                        'category' => 'Web Design',
                        'author' => 'Daniel Martin',
                        'date' => '24 March 2023',
                        'image' => 'blog-1.jpg',
                        'excerpt' => 'Discover the latest web design trends that are shaping the digital landscape in 2024. From minimalist layouts to interactive elements.',
                        'shares' => 5324,
                        'comments' => 5
                    ],
                    [
                        'slug' => 'php-laravel-development-best-practices',
                        'title' => 'PHP Laravel Development Best Practices',
                        'category' => 'Development',
                        'author' => 'Sarah Johnson',
                        'date' => '23 April 2023',
                        'image' => 'blog-2.jpg',
                        'excerpt' => 'Learn essential Laravel development practices that will make your code more maintainable, secure, and efficient.',
                        'shares' => 4521,
                        'comments' => 8
                    ],
                    [
                        'slug' => 'mobile-app-development-guide',
                        'title' => 'Complete Guide to Mobile App Development',
                        'category' => 'Mobile App',
                        'author' => 'Michael Chen',
                        'date' => '30 Jan 2023',
                        'image' => 'blog-3.jpg',
                        'excerpt' => 'Everything you need to know about mobile app development, from planning to deployment across different platforms.',
                        'shares' => 6789,
                        'comments' => 12
                    ]
                ];
            @endphp

            @foreach($featuredBlogs as $index => $blog)
            <div class="col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="{{ 0.3 + ($index * 0.2) }}s">
                <div class="blog-item position-relative bg-light rounded">
                    <img src="{{ asset('img/' . $blog['image']) }}" class="img-fluid w-100 rounded-top" alt="{{ $blog['title'] }}">
                    <span class="position-absolute px-4 py-3 bg-primary text-white rounded" style="top: -28px; right: 20px;">{{ $blog['category'] }}</span>
                    <div class="blog-btn d-flex justify-content-between position-relative px-3" style="margin-top: -75px;">
                        <div class="blog-icon btn btn-secondary px-3 rounded-pill my-auto">
                            <a href="{{ route('blog.show', $blog['slug']) }}" class="btn text-white">Read More</a>
                        </div>
                        <div class="blog-btn-icon btn btn-secondary px-4 py-3 rounded-pill ">
                            <div class="blog-icon-1">
                                <p class="text-white px-2">Share<i class="fa fa-arrow-right ms-3"></i></p>
                            </div>
                            <div class="blog-icon-2">
                                <a href="" class="btn me-1"><i class="fab fa-facebook-f text-white"></i></a>
                                <a href="" class="btn me-1"><i class="fab fa-twitter text-white"></i></a>
                                <a href="" class="btn me-1"><i class="fab fa-instagram text-white"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="blog-content text-center position-relative px-3" style="margin-top: -25px;">
                        <img src="{{ asset('img/admin.jpg') }}" class="img-fluid rounded-circle border border-4 border-white mb-3" alt="">
                        <h5 class="">By {{ $blog['author'] }}</h5>
                        <span class="text-secondary">{{ $blog['date'] }}</span>
                        <p class="py-2">{{ $blog['excerpt'] }}</p>
                    </div>
                    <div class="blog-coment d-flex justify-content-between px-4 py-2 border bg-primary rounded-bottom">
                        <a href="" class="text-white"><small><i class="fas fa-share me-2 text-secondary"></i>{{ $blog['shares'] }} Share</small></a>
                        <a href="" class="text-white"><small><i class="fa fa-comments me-2 text-secondary"></i>{{ $blog['comments'] }} Comments</small></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- View All Blogs Button -->
        <div class="text-center mt-5">
            <a href="{{ route('blogs') }}" class="btn btn-primary py-3 px-5 rounded-pill">View All Blogs</a>
        </div>
    </div>
</div>
<!-- Blog End -->
