@extends('admin.layout.app')

@section('title', 'Tag: ' . $tag->name)
@section('page-title', 'Tag Details')

@section('page-actions')
<div class="d-flex gap-2">
    <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-primary">
        <i class="fas fa-edit me-2"></i>Edit Tag
    </a>
    <a href="{{ route('admin.tags.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Tags
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <!-- Tag Details -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Tag Information</h5>
                    <div>
                        @if($tag->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Tag Header -->
                <div class="d-flex align-items-center mb-4">
                    <div class="me-3">
                        <span class="badge fs-4 px-3 py-2" style="background-color: {{ $tag->color }}">
                            {{ $tag->name }}
                        </span>
                    </div>
                    <div>
                        <h2 class="mb-1">{{ $tag->name }}</h2>
                        <div class="mb-2">
                            <code>{{ $tag->slug }}</code>
                        </div>
                        <small class="text-muted">Created {{ $tag->created_at->format('M d, Y') }}</small>
                    </div>
                </div>

                <!-- Description -->
                @if($tag->description)
                <div class="mb-4">
                    <h6>Description:</h6>
                    <p class="text-muted">{{ $tag->description }}</p>
                </div>
                @endif

                <!-- SEO Information -->
                @if($tag->meta_title || $tag->meta_description)
                <div class="mb-4">
                    <h6>SEO Information:</h6>
                    @if($tag->meta_title)
                        <div class="mb-2">
                            <small class="text-muted">Meta Title:</small>
                            <div>{{ $tag->meta_title }}</div>
                        </div>
                    @endif
                    @if($tag->meta_description)
                        <div class="mb-2">
                            <small class="text-muted">Meta Description:</small>
                            <div>{{ $tag->meta_description }}</div>
                        </div>
                    @endif
                </div>
                @endif

                <!-- Recent Posts -->
                @if($recentPosts->count() > 0)
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6>Posts with this Tag</h6>
                        @if($tag->posts()->count() > $recentPosts->count())
                            <a href="{{ route('admin.posts.index', ['tag' => $tag->id]) }}" class="btn btn-sm btn-outline-primary">
                                View All Posts ({{ $tag->posts()->count() }})
                            </a>
                        @endif
                    </div>

                    @foreach($recentPosts as $post)
                    <div class="d-flex mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                        @if($post->featured_image)
                            <img src="{{ $post->featured_image_url }}" class="rounded me-3" width="60" height="60" style="object-fit: cover;" alt="">
                        @endif
                        <div class="flex-grow-1">
                            <h6 class="mb-1">
                                <a href="{{ route('admin.posts.show', $post) }}" class="text-decoration-none">
                                    {{ $post->title }}
                                </a>
                            </h6>
                            <div class="small text-muted mb-1">
                                <span class="badge" style="background-color: {{ $post->category->color }}; font-size: 0.7rem;">
                                    {{ $post->category->name }}
                                </span>
                                <span class="ms-2">By {{ $post->staff->name }} • {{ $post->published_date ?: 'Draft' }}</span>
                                @if($post->is_featured)
                                    <span class="badge bg-warning text-dark ms-1">Featured</span>
                                @endif
                            </div>
                            <p class="mb-0 small text-muted">{{ Str::limit($post->excerpt, 100) }}</p>
                            <div class="small text-muted">
                                {{ $post->views_count }} views • {{ $post->approvedComments->count() }} comments
                            </div>
                        </div>
                        <div class="text-end">
                            @if($post->status === 'published')
                                <span class="badge bg-success">Published</span>
                            @elseif($post->status === 'draft')
                                <span class="badge bg-secondary">Draft</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ ucfirst($post->status) }}</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-tag fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">No posts with this tag yet</h6>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-1"></i>Create Post with this Tag
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Statistics -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <h3 class="text-primary mb-1">{{ $tag->posts()->count() }}</h3>
                        <small class="text-muted">Total Posts</small>
                    </div>
                    <div class="col-6 mb-3">
                        <h3 class="text-success mb-1">{{ $tag->posts()->where('status', 'published')->count() }}</h3>
                        <small class="text-muted">Published</small>
                    </div>
                    <div class="col-6">
                        <h3 class="text-warning mb-1">{{ $tag->posts()->where('status', 'draft')->count() }}</h3>
                        <small class="text-muted">Drafts</small>
                    </div>
                    <div class="col-6">
                        <h3 class="text-info mb-1">{{ $tag->posts()->sum('views_count') }}</h3>
                        <small class="text-muted">Total Views</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Tag
                    </a>

                    <form method="POST" action="{{ route('admin.tags.toggle-status', $tag) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-toggle-{{ $tag->status === 'active' ? 'on' : 'off' }} me-2"></i>
                            {{ $tag->status === 'active' ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>

                    @if($tag->posts()->count() > 0)
                    <a href="{{ route('admin.posts.index', ['tag' => $tag->id]) }}" class="btn btn-outline-info">
                        <i class="fas fa-file-alt me-2"></i>View All Posts
                    </a>
                    @endif

                    <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-success">
                        <i class="fas fa-plus me-2"></i>Create New Post
                    </a>

                    @if($tag->posts()->count() === 0)
                    <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" onsubmit="return confirmDelete('Are you sure you want to delete this tag?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i>Delete Tag
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tag Information -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Name:</label>
                    <div>{{ $tag->name }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Slug:</label>
                    <div><code>{{ $tag->slug }}</code></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Color:</label>
                    <div class="d-flex align-items-center">
                        <div class="color-preview me-2" style="width: 20px; height: 20px; background-color: {{ $tag->color }}; border-radius: 3px; border: 1px solid #ddd;"></div>
                        <code>{{ $tag->color }}</code>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status:</label>
                    <div>
                        @if($tag->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Created:</label>
                    <div>{{ $tag->created_at->format('M d, Y \a\t h:i A') }}</div>
                </div>

                @if($tag->updated_at != $tag->created_at)
                <div class="mb-3">
                    <label class="form-label fw-bold">Last Updated:</label>
                    <div>{{ $tag->updated_at->format('M d, Y \a\t h:i A') }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Navigation -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Navigation</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.tags.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-tags me-2"></i>All Tags
                    </a>
                    <a href="{{ route('admin.tags.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>Create New Tag
                    </a>
                    @if($tag->posts()->count() > 0)
                    <a href="{{ route('blogs.tag', $tag->slug) }}" target="_blank" class="btn btn-outline-success">
                        <i class="fas fa-external-link-alt me-2"></i>View Live Tag
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
