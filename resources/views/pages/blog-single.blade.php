@extends('layouts.master')

@section('content')

<!-- Page Header Start -->
<div class="container-fluid page-header py-5">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white mb-4 animated slideInDown">{{ $blog->title }}</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blogs') }}">Blogs</a></li>
                <li class="breadcrumb-item text-white" aria-current="page">{{ $blog->category->name }}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->
<!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
<!-- Blog Details Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Blog Post -->
                <div class="blog-item bg-light rounded">
                    <img src="{{ $blog->featured_image_url }}" class="img-fluid w-100 rounded-top" alt="{{ $blog->title }}">

                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="px-4 py-2 bg-primary text-white rounded">{{ $blog->category->name }}</span>
                            <small class="text-muted">{{ $blog->published_date }}</small>
                        </div>

                        <h2 class="mb-3">{{ $blog->title }}</h2>

                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $blog->staff->avatar_url }}" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $blog->staff->name }}">
                            <div>
                                <h6 class="mb-1">{{ $blog->staff->name }}</h6>
                                <small class="text-muted">{{ $blog->staff->position ?? 'Author' }}</small>
                            </div>
                        </div>

                        @if($blog->excerpt)
                        <p class="mb-4 lead">{{ $blog->excerpt }}</p>
                        @endif

                        <div class="blog-content">
                            {!! $blog->content !!}
                        </div>

                        <!-- Post Meta Info -->
                        <div class="row mt-4 pt-3 border-top">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i> {{ $blog->reading_time_text }}
                                </small>
                            </div>
                            <div class="col-md-6 text-end">
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i> {{ number_format($blog->views_count ?? 0) }} views
                                </small>
                            </div>
                        </div>

                        <!-- Tags -->
                        @if($blog->tags->count() > 0)
                        <div class="mt-3">
                            <strong>Tags: </strong>
                            @foreach($blog->tags as $tag)
                                <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        @endif

                        <!-- Social Share -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                            <div class="d-flex">
                                <span class="me-3"><i class="fas fa-eye me-2 text-primary"></i>{{ number_format($blog->views_count ?? 0) }} Views</span>
                                <span><i class="fa fa-comments me-2 text-primary"></i>{{ $blog->approvedComments->count() }} Comments</span>
                            </div>
                            <div>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-outline-primary btn-sm me-2"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($blog->title) }}" target="_blank" class="btn btn-outline-primary btn-sm me-2"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-outline-primary btn-sm me-2"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" onclick="navigator.clipboard.writeText('{{ request()->url() }}')" class="btn btn-outline-primary btn-sm"><i class="fas fa-link"></i></a>
                            </div>
                        </div>

                        <!-- Navigation -->
                        @if($previousPost || $nextPost)
                        <div class="row mt-4 pt-4 border-top">
                            <div class="col-md-6">
                                @if($previousPost)
                                <a href="{{ route('blog.show', $previousPost->slug) }}" class="text-decoration-none">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-chevron-left me-2"></i>
                                        <div>
                                            <small class="text-muted">Previous Post</small>
                                            <h6 class="mb-0">{{ Str::limit($previousPost->title, 30) }}</h6>
                                        </div>
                                    </div>
                                </a>
                                @endif
                            </div>
                            <div class="col-md-6 text-end">
                                @if($nextPost)
                                <a href="{{ route('blog.show', $nextPost->slug) }}" class="text-decoration-none">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <div class="text-end">
                                            <small class="text-muted">Next Post</small>
                                            <h6 class="mb-0">{{ Str::limit($nextPost->title, 30) }}</h6>
                                        </div>
                                        <i class="fas fa-chevron-right ms-2"></i>
                                    </div>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="bg-light rounded p-4 mt-4">
                    <h4 class="mb-4">Comments ({{ $blog->approvedComments->count() }})</h4>

                    @if($blog->approvedComments->count() > 0)
                        @foreach($blog->approvedComments as $comment)
                        <div class="d-flex mb-4 {{ !$loop->last ? 'border-bottom pb-4' : '' }}">
                            <img src="{{ $comment->avatar }}" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px;" alt="{{ $comment->name }}">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <h6>{{ $comment->name }}</h6>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0">{!! nl2br(e($comment->content)) !!}</p>

                                @if($comment->website)
                                <small class="text-muted">
                                    <a href="{{ $comment->website }}" target="_blank" class="text-decoration-none">
                                        <i class="fas fa-external-link-alt me-1"></i>Website
                                    </a>
                                </small>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted">No comments yet. Be the first to comment!</p>
                    @endif

                    <!-- Add Comment Form -->
@if($blog->allow_comments)
<div class="mt-4">
    <h5>Leave a Comment</h5>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Validation Errors -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('blog.comments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="post_id" value="{{ $blog->id }}">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           placeholder="Your Name*" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           placeholder="Your Email*" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="mb-3">
            <input type="url" name="website" class="form-control @error('website') is-invalid @enderror"
                   placeholder="Your Website (Optional)" value="{{ old('website') }}">
            @error('website')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                      rows="4" placeholder="Your Comment*" required>{{ old('content') }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Post Comment</button>
    </form>
</div>
@else
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>Comments are disabled for this post.
    </div>
@endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Recent Posts -->
                @if($relatedBlogs->count() > 0)
                <div class="bg-light rounded p-4 mb-4">
                    <h4 class="mb-4">Related Posts</h4>
                    @foreach($relatedBlogs as $relatedBlog)
                    <div class="d-flex mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                        <img src="{{ $relatedBlog->featured_image_url }}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;" alt="{{ $relatedBlog->title }}">
                        <div class="ms-3">
                            <a href="{{ route('blog.show', $relatedBlog->slug) }}" class="h6 text-decoration-none">{{ Str::limit($relatedBlog->title, 50) }}</a>
                            <small class="text-muted d-block">{{ $relatedBlog->published_date }}</small>
                            <small class="text-muted">By {{ $relatedBlog->staff->name }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Categories -->
                @php
                    $categories = App\Models\PostCategory::where('status', 'active')
                        ->withCount(['posts' => function($query) {
                            $query->where('status', 'published');
                        }])
                        ->orderBy('name')
                        ->get();
                @endphp
                @if($categories->count() > 0)
                <div class="bg-light rounded p-4 mb-4">
                    <h4 class="mb-4">Categories</h4>
                    <ul class="list-unstyled">
                        @foreach($categories as $category)
                        <li class="mb-2">
                            <a href="{{ route('blogs.category', $category->slug) }}" class="text-decoration-none">
                                {{ $category->name }} <span class="text-muted">({{ $category->posts_count }})</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Tags -->
                @php
                    $popularTags = App\Models\PostTag::where('status', 'active')
                        ->withCount('publishedPosts')
                        ->orderBy('published_posts_count', 'desc')
                        ->take(10)
                        ->get();
                @endphp
                @if($popularTags->count() > 0)
                <div class="bg-light rounded p-4">
                    <h4 class="mb-4">Popular Tags</h4>
                    <div>
                        @foreach($popularTags as $tag)
                        <a href="{{ route('blogs.tag', $tag->slug) }}" class="btn btn-outline-primary btn-sm me-2 mb-2">
                            {{ $tag->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Blog Details End -->

@endsection
