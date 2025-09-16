<!-- Blog Start -->
<div class="container-fluid blog py-5 mb-5">
    <div class="container">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
            <h5 class="text-primary">Our Blog</h5>
            <h1>Latest Blog & News</h1>
        </div>
        <div class="row g-5 justify-content-center">
            @php
                // Get featured blogs from database - limit to 3 posts for homepage
                $featuredBlogs = App\Models\Post::with(['staff', 'category', 'approvedComments'])
                    ->where('status', 'published')
                    ->where('is_featured', true)
                    ->orderBy('published_at', 'desc')
                    ->take(3)
                    ->get();

                // If no featured posts, get recent posts
                if ($featuredBlogs->count() < 3) {
                    $recentBlogs = App\Models\Post::with(['staff', 'category', 'approvedComments'])
                        ->where('status', 'published')
                        ->whereNotIn('id', $featuredBlogs->pluck('id'))
                        ->orderBy('published_at', 'desc')
                        ->take(3 - $featuredBlogs->count())
                        ->get();

                    $featuredBlogs = $featuredBlogs->merge($recentBlogs);
                }
            @endphp

            @if($featuredBlogs->count() > 0)
                @foreach($featuredBlogs as $index => $blog)
                <div class="col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="{{ 0.3 + ($index * 0.2) }}s">
                    <div class="blog-item position-relative bg-light rounded">
                        <img src="{{ $blog->featured_image_url }}" class="img-fluid w-100 rounded-top" alt="{{ $blog->title }}">
                        <span class="position-absolute px-4 py-3 bg-primary text-white rounded" style="top: -28px; right: 20px;">
                            {{ $blog->category->name }}
                        </span>
                        <div class="blog-btn d-flex justify-content-between position-relative px-3" style="margin-top: -75px;">
                            <div class="blog-icon btn btn-secondary px-3 rounded-pill my-auto">
                                <a href="{{ route('blog.show', $blog->slug) }}" class="btn text-white">Read More</a>
                            </div>
                            <div class="blog-btn-icon btn btn-secondary px-4 py-3 rounded-pill ">
                                <div class="blog-icon-1">
                                    <p class="text-white px-2">Share<i class="fa fa-arrow-right ms-3"></i></p>
                                </div>
                                <div class="blog-icon-2">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $blog->slug)) }}" target="_blank" class="btn me-1">
                                        <i class="fab fa-facebook-f text-white"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}" target="_blank" class="btn me-1">
                                        <i class="fab fa-twitter text-white"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('blog.show', $blog->slug)) }}" target="_blank" class="btn me-1">
                                        <i class="fab fa-linkedin text-white"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="blog-content text-center position-relative px-3" style="margin-top: -25px;">
                            <img src="{{ $blog->staff->avatar_url }}" class="img-fluid rounded-circle border border-4 border-white mb-3" alt="{{ $blog->staff->name }}" style="width: 60px; height: 60px; object-fit: cover;">
                            <h5 class="mb-2">{{ Str::limit($blog->title, 40) }}</h5>
                            <span class="text-secondary">{{ $blog->published_date }}</span>
                            <p class="py-2">{{ $blog->excerpt }}</p>
                            @if($blog->is_featured)
                                <span class="badge bg-warning text-dark mb-2">Featured</span>
                            @endif
                        </div>
                        <div class="blog-coment d-flex justify-content-between px-4 py-2 border bg-primary rounded-bottom">
                            <a href="#" class="text-white">
                                <small><i class="fas fa-eye me-2 text-secondary"></i>{{ number_format($blog->views_count ?? 0) }} Views</small>
                            </a>
                            <a href="{{ route('blog.show', $blog->slug) }}#comments" class="text-white">
                                <small><i class="fa fa-comments me-2 text-secondary"></i>{{ $blog->approved_comments_count ?? $blog->approvedComments->count() }} Comments</small>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- No blogs available message -->
                <div class="col-12">
                    <div class="text-center py-5">
                        <h4 class="text-muted">No blog posts available at the moment.</h4>
                        <p class="text-muted">Please check back later for new content.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- View All Blogs Button -->
        @if($featuredBlogs->count() > 0)
        <div class="text-center mt-5">
            <a href="{{ route('blogs') }}" class="btn btn-primary py-3 px-5 rounded-pill">View All Blogs</a>
        </div>
        @endif
    </div>
</div>
<!-- Blog End -->
