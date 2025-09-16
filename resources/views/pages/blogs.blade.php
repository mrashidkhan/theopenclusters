@extends('layouts.master')

@section('title', 'Blogs')

@section('page-title', 'Blogs')

@section('content')

<!-- Page Header Start -->
<div class="container-fluid page-header py-5">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4 animated slideInDown">Our Blogs</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                <li class="breadcrumb-item text-white" aria-current="page">Blogs</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Blog Section Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Search and Filter -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <form method="GET" action="{{ route('blogs') }}">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search blogs..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form method="GET" action="{{ route('blogs') }}">
                            <select name="category" class="form-select" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->posts_count }})
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Results Info -->
                @if(request('search') || request('category'))
                <div class="alert alert-info">
                    <strong>{{ $totalPosts ?? $blogs->count() }}</strong> posts found
                    @if(request('search'))
                        for "<strong>{{ request('search') }}</strong>"
                    @endif
                    @if(request('category'))
                        in category "<strong>{{ $categories->where('slug', request('category'))->first()->name ?? request('category') }}</strong>"
                    @endif
                    <a href="{{ route('blogs') }}" class="ms-3 text-decoration-none">Clear filters</a>
                </div>
                @endif

                <!-- Blog Posts Grid -->
                @if($blogs->count() > 0)
                    <div class="row g-4" id="blog-posts-container">
                        @foreach($blogs as $blog)
                        <div class="col-md-6 mb-4 blog-post-item">
                            <div class="blog-item bg-light rounded h-100">
                                <div class="position-relative">
                                    <img src="{{ $blog->featured_image_url }}" class="img-fluid w-100 rounded-top" style="height: 250px; object-fit: cover;" alt="{{ $blog->title }}">
                                    <span class="position-absolute top-0 end-0 m-3 px-3 py-1 bg-primary text-white rounded">
                                        {{ $blog->category->name }}
                                    </span>
                                    @if($blog->is_featured)
                                        <span class="position-absolute top-0 start-0 m-3 badge bg-warning text-dark">Featured</span>
                                    @endif
                                </div>

                                <div class="p-4 d-flex flex-column">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ $blog->staff->avatar_url }}" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;" alt="{{ $blog->staff->name }}">
                                        <small class="text-muted">By {{ $blog->staff->name }}</small>
                                        <small class="text-muted ms-auto">{{ $blog->published_date }}</small>
                                    </div>

                                    <h5 class="mb-3">
                                        <a href="{{ route('blog.show', $blog->slug) }}" class="text-decoration-none text-dark">
                                            {{ $blog->title }}
                                        </a>
                                    </h5>

                                    <p class="text-muted mb-3 flex-grow-1">{{ Str::limit($blog->excerpt, 120) }}</p>

                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <div class="d-flex">
                                            <small class="text-muted me-3">
                                                <i class="fas fa-eye me-1"></i>{{ number_format($blog->views_count ?? 0) }}
                                            </small>
                                            <small class="text-muted me-3">
                                                <i class="fas fa-comments me-1"></i>{{ $blog->approvedComments->count() }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>{{ $blog->reading_time ?? 5 }} min
                                            </small>
                                        </div>
                                        <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-primary btn-sm">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Load More Button -->
                    @if(isset($totalPosts) && $totalPosts > $blogs->count())
                    <div class="text-center mt-5" id="load-more-container">
                        <button id="load-more-btn" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-plus me-2"></i>Load More Posts
                            <span class="badge bg-light text-primary ms-2">{{ $totalPosts - $blogs->count() }} remaining</span>
                        </button>
                        <div id="loading-spinner" class="d-none mt-3">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 text-muted">Loading more posts...</p>
                        </div>
                    </div>
                    @endif
                @else
                    <!-- No Results -->
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No blog posts found</h4>
                        <p class="text-muted">
                            @if(request('search') || request('category'))
                                Try adjusting your search criteria or <a href="{{ route('blogs') }}">view all posts</a>.
                            @else
                                Check back later for new content.
                            @endif
                        </p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Featured Posts -->
                @if($featuredPosts->count() > 0)
                <div class="bg-light rounded p-4 mb-4">
                    <h4 class="mb-4">Featured Posts</h4>
                    @foreach($featuredPosts as $post)
                    <div class="d-flex mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                        <img src="{{ $post->featured_image_url }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $post->title }}">
                        <div>
                            <a href="{{ route('blog.show', $post->slug) }}" class="h6 text-decoration-none">{{ Str::limit($post->title, 50) }}</a>
                            <small class="text-muted d-block">{{ $post->published_date }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Categories -->
                @if($categories->count() > 0)
                <div class="bg-light rounded p-4 mb-4">
                    <h4 class="mb-4">Categories</h4>
                    <ul class="list-unstyled">
                        @foreach($categories as $category)
                        <li class="mb-2">
                            <a href="{{ route('blogs') }}?category={{ $category->slug }}" class="text-decoration-none d-flex justify-content-between">
                                <span>{{ $category->name }}</span>
                                <span class="badge bg-secondary">{{ $category->posts_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Recent Posts -->
                @php
                    $recentPosts = App\Models\Post::with(['staff', 'category'])
                        ->where('status', 'published')
                        ->orderBy('published_at', 'desc')
                        ->take(5)
                        ->get();
                @endphp
                @if($recentPosts->count() > 0)
                <div class="bg-light rounded p-4 mb-4">
                    <h4 class="mb-4">Recent Posts</h4>
                    @foreach($recentPosts as $post)
                    <div class="d-flex mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                        <img src="{{ $post->featured_image_url }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $post->title }}">
                        <div>
                            <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none">{{ Str::limit($post->title, 45) }}</a>
                            <small class="text-muted d-block">{{ $post->published_date }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Newsletter Signup -->
                <div class="bg-primary text-white rounded p-4">
                    <h4 class="mb-3">Stay Updated</h4>
                    <p class="mb-3">Subscribe to our newsletter to get the latest blog posts delivered to your inbox.</p>
                    <form>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Your email address" required>
                        </div>
                        <button type="submit" class="btn btn-light w-100">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog Section End -->

<!-- JavaScript directly in the template -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('load-more-btn');

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const loadingSpinner = document.getElementById('loading-spinner');
            const blogContainer = document.getElementById('blog-posts-container');
            const loadMoreContainer = document.getElementById('load-more-container');

            // Show loading state
            loadMoreBtn.style.display = 'none';
            loadingSpinner.classList.remove('d-none');

            // Get current search parameters
            const urlParams = new URLSearchParams(window.location.search);
            const searchParam = urlParams.get('search') || '';
            const categoryParam = urlParams.get('category') || '';

            // Build AJAX URL
            let ajaxUrl = `{{ route('blogs') }}?load_more=1`;
            if (searchParam) ajaxUrl += `&search=${encodeURIComponent(searchParam)}`;
            if (categoryParam) ajaxUrl += `&category=${encodeURIComponent(categoryParam)}`;

            // Make AJAX request
            fetch(ajaxUrl, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data.success || !Array.isArray(data.blogs)) {
                    throw new Error('Invalid response format');
                }

                // Clear existing posts
                blogContainer.innerHTML = '';

                // Add all posts
                data.blogs.forEach(blog => {
                    const featuredBadge = blog.is_featured ?
                        '<span class="position-absolute top-0 start-0 m-3 badge bg-warning text-dark">Featured</span>' : '';

                    const blogHtml = `
                        <div class="col-md-6 mb-4 blog-post-item">
                            <div class="blog-item bg-light rounded h-100">
                                <div class="position-relative">
                                    <img src="${blog.featured_image_url}" class="img-fluid w-100 rounded-top" style="height: 250px; object-fit: cover;" alt="${blog.title}">
                                    <span class="position-absolute top-0 end-0 m-3 px-3 py-1 bg-primary text-white rounded">
                                        ${blog.category_name}
                                    </span>
                                    ${featuredBadge}
                                </div>
                                <div class="p-4 d-flex flex-column">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="${blog.staff_avatar_url}" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;" alt="${blog.staff_name}">
                                        <small class="text-muted">By ${blog.staff_name}</small>
                                        <small class="text-muted ms-auto">${blog.published_date}</small>
                                    </div>
                                    <h5 class="mb-3">
                                        <a href="${blog.blog_show_url}" class="text-decoration-none text-dark">
                                            ${blog.title}
                                        </a>
                                    </h5>
                                    <p class="text-muted mb-3 flex-grow-1">${blog.excerpt}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <div class="d-flex">
                                            <small class="text-muted me-3">
                                                <i class="fas fa-eye me-1"></i>${blog.views_count.toLocaleString()}
                                            </small>
                                            <small class="text-muted me-3">
                                                <i class="fas fa-comments me-1"></i>${blog.comments_count}
                                            </small>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>${blog.reading_time} min
                                            </small>
                                        </div>
                                        <a href="${blog.blog_show_url}" class="btn btn-primary btn-sm">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    blogContainer.insertAdjacentHTML('beforeend', blogHtml);
                });

                // Hide load more section
                loadMoreContainer.style.display = 'none';
            })
            .catch(error => {
                // Reset UI and show error
                loadingSpinner.classList.add('d-none');
                loadMoreBtn.style.display = 'block';
                loadMoreBtn.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Error loading posts. Try again.';
                loadMoreBtn.classList.remove('btn-primary');
                loadMoreBtn.classList.add('btn-danger');
            });
        });
    }
});
</script>

@endsection
