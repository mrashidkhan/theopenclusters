@extends('admin.layout.app')

@section('title', 'Staff Profile: ' . $staff->name)
@section('page-title', 'Staff Profile')

@section('page-actions')
<div class="d-flex gap-2">
    <a href="{{ route('admin.staff.edit', $staff) }}" class="btn btn-primary">
        <i class="fas fa-edit me-2"></i>Edit Profile
    </a>
    <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Staff
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <!-- Staff Profile -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <!-- Profile Header -->
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ $staff->avatar_url }}" class="rounded-circle me-4" width="100" height="100" alt="{{ $staff->name }}">
                    <div>
                        <h2 class="mb-1">{{ $staff->name }}</h2>
                        @if($staff->position)
                            <h5 class="text-muted mb-2">{{ $staff->position }}</h5>
                        @endif
                        <div class="d-flex align-items-center mb-2">
                            @if($staff->status === 'active')
                                <span class="badge bg-success me-2">Active</span>
                            @else
                                <span class="badge bg-secondary me-2">Inactive</span>
                            @endif
                            <small class="text-muted">Member since {{ $staff->created_at->format('M Y') }}</small>
                        </div>

                        <!-- Social Links -->
                        @if($staff->social_links)
                        <div class="social-links">
                            @foreach($staff->social_links as $platform => $url)
                                @if($url)
                                    <a href="{{ $url }}" target="_blank" class="btn btn-outline-secondary btn-sm me-2" title="{{ ucfirst($platform) }}">
                                        <i class="fab fa-{{ $platform }}"></i>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mb-4">
                    <h5>Contact Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <i class="fas fa-envelope me-2 text-muted"></i>
                                <a href="mailto:{{ $staff->email }}">{{ $staff->email }}</a>
                            </div>
                            @if($staff->phone)
                            <div class="mb-2">
                                <i class="fas fa-phone me-2 text-muted"></i>
                                <a href="tel:{{ $staff->phone }}">{{ $staff->phone }}</a>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <i class="fas fa-link me-2 text-muted"></i>
                                <code>{{ $staff->slug }}</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bio -->
                @if($staff->bio)
                <div class="mb-4">
                    <h5>About</h5>
                    <p class="text-muted">{{ $staff->bio }}</p>
                </div>
                @endif

                <!-- Recent Posts -->
                @if($recentPosts->count() > 0)
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Recent Posts</h5>
                        @if($staff->posts()->count() > $recentPosts->count())
                            <a href="{{ route('admin.posts.index', ['author' => $staff->id]) }}" class="btn btn-sm btn-outline-primary">
                                View All Posts ({{ $staff->posts()->count() }})
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
                                <span class="ms-2">{{ $post->published_date ?: 'Draft' }}</span>
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
                        <h3 class="text-primary mb-1">{{ $staff->posts_count }}</h3>
                        <small class="text-muted">Total Posts</small>
                    </div>
                    <div class="col-6 mb-3">
                        <h3 class="text-success mb-1">{{ $staff->published_posts_count }}</h3>
                        <small class="text-muted">Published</small>
                    </div>
                    <div class="col-6">
                        <h3 class="text-info mb-1">{{ $staff->posts()->where('status', 'draft')->count() }}</h3>
                        <small class="text-muted">Drafts</small>
                    </div>
                    <div class="col-6">
                        <h3 class="text-warning mb-1">{{ $staff->posts()->sum('views_count') }}</h3>
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
                    <a href="{{ route('admin.staff.edit', $staff) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Profile
                    </a>

                    <form method="POST" action="{{ route('admin.staff.toggle-status', $staff) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-toggle-{{ $staff->status === 'active' ? 'on' : 'off' }} me-2"></i>
                            {{ $staff->status === 'active' ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>

                    @if($staff->posts()->count() > 0)
                    <a href="{{ route('admin.posts.index', ['author' => $staff->id]) }}" class="btn btn-outline-info">
                        <i class="fas fa-file-alt me-2"></i>View All Posts
                    </a>
                    @endif

                    <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-success">
                        <i class="fas fa-plus me-2"></i>Create New Post
                    </a>
                </div>
            </div>
        </div>

        <!-- Staff Information -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Full Name:</label>
                    <div>{{ $staff->name }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email:</label>
                    <div>{{ $staff->email }}</div>
                </div>

                @if($staff->position)
                <div class="mb-3">
                    <label class="form-label fw-bold">Position:</label>
                    <div>{{ $staff->position }}</div>
                </div>
                @endif

                @if($staff->phone)
                <div class="mb-3">
                    <label class="form-label fw-bold">Phone:</label>
                    <div>{{ $staff->phone }}</div>
                </div>
                @endif

                <div class="mb-3">
                    <label class="form-label fw-bold">URL Slug:</label>
                    <div><code>{{ $staff->slug }}</code></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status:</label>
                    <div>
                        @if($staff->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Member Since:</label>
                    <div>{{ $staff->created_at->format('M d, Y') }}</div>
                </div>

                @if($staff->updated_at != $staff->created_at)
                <div class="mb-3">
                    <label class="form-label fw-bold">Last Updated:</label>
                    <div>{{ $staff->updated_at->format('M d, Y') }}</div>
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
                    @if($staff->posts()->where('status', 'draft')->count() > 0)
                    <a href="{{ route('admin.posts.index', ['author' => $staff->id, 'status' => 'draft']) }}" class="btn btn-outline-warning">
                        <i class="fas fa-edit me-2"></i>Draft Posts ({{ $staff->posts()->where('status', 'draft')->count() }})
                    </a>
                    @endif

                    @if($staff->posts()->where('status', 'published')->count() > 0)
                    <a href="{{ route('admin.posts.index', ['author' => $staff->id, 'status' => 'published']) }}" class="btn btn-outline-success">
                        <i class="fas fa-eye me-2"></i>Published Posts ({{ $staff->posts()->where('status', 'published')->count() }})
                    </a>
                    @endif

                    <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-users me-2"></i>All Staff Members
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
