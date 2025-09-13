@extends('admin.layout.app')

@section('title', 'Post: ' . $post->title)
@section('page-title', 'Post Details')

@section('page-actions')
<div class="d-flex gap-2">
    <a href="{{ route('blog.show', $post) }}" target="_blank" class="btn btn-outline-info">
        <i class="fas fa-external-link-alt me-2"></i>View Live
    </a>
    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary">
        <i class="fas fa-edit me-2"></i>Edit Post
    </a>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Posts
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <!-- Post Content -->
    <div class="col-lg-8">
        <!-- Post Header -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        @if($post->status === 'published')
                            <span class="badge bg-success mb-2">Published</span>
                        @elseif($post->status === 'draft')
                            <span class="badge bg-secondary mb-2">Draft</span>
                        @else
                            <span class="badge bg-warning text-dark mb-2">{{ ucfirst($post->status) }}</span>
                        @endif

                        @if($post->is_featured)
                            <span class="badge featured-badge mb-2 ms-1">
                                <i class="fas fa-star me-1"></i>Featured
                            </span>
                        @endif
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <form method="POST" action="{{ route('admin.posts.toggle-status', $post) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-{{ $post->status === 'published' ? 'eye-slash' : 'eye' }} me-2"></i>
                                        {{ $post->status === 'published' ? 'Unpublish' : 'Publish' }}
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.posts.toggle-featured', $post) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-star me-2"></i>
                                        {{ $post->is_featured ? 'Remove Featured' : 'Make Featured' }}
                                    </button>
                                </form>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="d-inline" onsubmit="return confirmDelete('Are you sure you want to delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-trash me-2"></i>Delete Post
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <h1 class="h3 mb-3">{{ $post->title }}</h1>

                <div class="d-flex align-items-center text-muted mb-4">
                    <img src="{{ $post->staff->avatar_url }}" class="rounded-circle me-2" width="32" height="32" alt="">
                    <span class="me-3">By <strong>{{ $post->staff->name }}</strong></span>
                    <span class="me-3">{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not published' }}</span>
                    <span class="me-3">{{ $post->reading_time_text }}</span>
                </div>

                @if($post->featured_image)
                <div class="mb-4">
                    <img src="{{ $post->featured_image_url }}" class="img-fluid rounded" alt="{{ $post->title }}">
                </div>
                @endif

                <div class="mb-4">
                    <h6>Excerpt:</h6>
                    <p class="text-muted">{{ $post->excerpt }}</p>
                </div>

                <div class="content">
                    {!! $post->content !!}
                </div>

                @if($post->tags->count() > 0)
                <div class="mt-4 pt-4 border-top">
                    <h6>Tags:</h6>
                    <div>
                        @foreach($post->tags as $tag)
                        <a href="{{ route('admin.tags.show', $tag) }}" class="badge text-decoration-none me-2 mb-2" style="background-color: {{ $tag->color }}">
                            {{ $tag->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Comments Section -->
        @if($post->comments->count() > 0)
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Comments ({{ $post->comments->count() }})</h5>
                <a href="{{ route('admin.comments.index', ['post' => $post->id]) }}" class="btn btn-sm btn-outline-primary">
                    Manage Comments
                </a>
            </div>
            <div class="card-body">
                @foreach($post->comments->take(5) as $comment)
                <div class="d-flex mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                    <img src="{{ $comment->avatar }}" class="rounded-circle me-3" width="40" height="40" alt="">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $comment->name }}</h6>
                                <p class="mb-2">{{ Str::limit($comment->content, 150) }}</p>
                                <small class="text-muted">{{ $comment->formatted_date }}</small>
                            </div>
                            <div>
                                @if($comment->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($comment->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($comment->status === 'spam')
                                    <span class="badge bg-danger">Spam</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($comment->status) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @if($post->comments->count() > 5)
                <div class="text-center">
                    <a href="{{ route('admin.comments.index', ['post' => $post->id]) }}" class="btn btn-outline-primary">
                        View All {{ $post->comments->count() }} Comments
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Post Statistics -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <h3 class="text-primary mb-1">{{ number_format($post->views_count) }}</h3>
                        <small class="text-muted">Views</small>
                    </div>
                    <div class="col-6 mb-3">
                        <h3 class="text-success mb-1">{{ $post->comments->count() }}</h3>
                        <small class="text-muted">Comments</small>
                    </div>
                    <div class="col-6">
                        <h3 class="text-info mb-1">{{ $post->approvedComments->count() }}</h3>
                        <small class="text-muted">Approved</small>
                    </div>
                    <div class="col-6">
                        <h3 class="text-warning mb-1">{{ $post->comments->where('status', 'pending')->count() }}</h3>
                        <small class="text-muted">Pending</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Post Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Post Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Author:</label>
                    <div class="d-flex align-items-center">
                        <img src="{{ $post->staff->avatar_url }}" class="rounded-circle me-2" width="24" height="24" alt="">
                        <a href="{{ route('admin.staff.show', $post->staff) }}" class="text-decoration-none">
                            {{ $post->staff->name }}
                        </a>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Category:</label>
                    <div>
                        <a href="{{ route('admin.categories.show', $post->category) }}" class="badge text-decoration-none" style="background-color: {{ $post->category->color }}">
                            {{ $post->category->name }}
                        </a>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status:</label>
                    <div>
                        @if($post->status === 'published')
                            <span class="badge bg-success">Published</span>
                        @elseif($post->status === 'draft')
                            <span class="badge bg-secondary">Draft</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ ucfirst($post->status) }}</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Dates:</label>
                    <div class="small">
                        <div><strong>Created:</strong> {{ $post->created_at->format('M d, Y \a\t h:i A') }}</div>
                        <div><strong>Updated:</strong> {{ $post->updated_at->format('M d, Y \a\t h:i A') }}</div>
                        @if($post->published_at)
                            <div><strong>Published:</strong> {{ $post->published_at->format('M d, Y \a\t h:i A') }}</div>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Reading Time:</label>
                    <div>{{ $post->reading_time_text }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Slug:</label>
                    <div class="small text-muted">{{ $post->slug }}</div>
                </div>

                @if($post->allow_comments)
                <div class="mb-3">
                    <span class="badge bg-info">
                        <i class="fas fa-comments me-1"></i>Comments Enabled
                    </span>
                </div>
                @endif
            </div>
        </div>

        <!-- SEO Information -->
        @if($post->meta_title || $post->meta_description || $post->focus_keyword)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-search me-2"></i>SEO Information
                </h5>
            </div>
            <div class="card-body">
                @if($post->meta_title)
                <div class="mb-3">
                    <label class="form-label fw-bold">Meta Title:</label>
                    <div class="small">{{ $post->meta_title }}</div>
                </div>
                @endif

                @if($post->meta_description)
                <div class="mb-3">
                    <label class="form-label fw-bold">Meta Description:</label>
                    <div class="small">{{ $post->meta_description }}</div>
                </div>
                @endif

                @if($post->focus_keyword)
                <div class="mb-3">
                    <label class="form-label fw-bold">Focus Keyword:</label>
                    <div>
                        <span class="badge bg-primary">{{ $post->focus_keyword }}</span>
                    </div>
                </div>
                @endif

                @if($post->meta_keywords)
                <div class="mb-3">
                    <label class="form-label fw-bold">Keywords:</label>
                    <div class="small">{{ $post->meta_keywords }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Post
                    </a>

                    <form method="POST" action="{{ route('admin.posts.toggle-status', $post) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-{{ $post->status === 'published' ? 'eye-slash' : 'eye' }} me-2"></i>
                            {{ $post->status === 'published' ? 'Unpublish' : 'Publish' }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.posts.toggle-featured', $post) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-warning w-100">
                            <i class="fas fa-star me-2"></i>
                            {{ $post->is_featured ? 'Remove Featured' : 'Make Featured' }}
                        </button>
                    </form>

                    @if($post->comments->where('status', 'pending')->count() > 0)
                    <a href="{{ route('admin.comments.index', ['post' => $post->id, 'status' => 'pending']) }}" class="btn btn-outline-info">
                        <i class="fas fa-clock me-2"></i>Review Pending Comments ({{ $post->comments->where('status', 'pending')->count() }})
                    </a>
                    @endif

                    <a href="{{ route('blog.show', $post) }}" target="_blank" class="btn btn-outline-success">
                        <i class="fas fa-external-link-alt me-2"></i>View Live Post
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
