@extends('admin.layout.app')

@section('title', 'Category: ' . $category->name)
@section('page-title', 'Category Details')

@section('page-actions')
<div class="d-flex gap-2">
    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
        <i class="fas fa-edit me-2"></i>Edit Category
    </a>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Categories
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <!-- Category Details -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Category Information</h5>
                    <div>
                        @if($category->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Category Header -->
                <div class="d-flex align-items-center mb-4">
                    <div class="me-3">
                        <div class="category-icon-large d-flex align-items-center justify-content-center rounded"
                             style="width: 80px; height: 80px; background-color: {{ $category->color }}20; border: 2px solid {{ $category->color }};">
                            @if($category->icon)
                                <i class="{{ $category->icon }} fa-2x" style="color: {{ $category->color }}"></i>
                            @else
                                <i class="fas fa-folder fa-2x" style="color: {{ $category->color }}"></i>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h2 class="mb-1">{{ $category->name }}</h2>
                        <div class="mb-2">
                            <span class="badge" style="background-color: {{ $category->color }}">
                                {{ $category->name }}
                            </span>
                            <code class="ms-2">{{ $category->slug }}</code>
                        </div>
                        <small class="text-muted">Created {{ $category->created_at->format('M d, Y') }}</small>
                    </div>
                </div>

                <!-- Description -->
                @if($category->description)
                <div class="mb-4">
                    <h6>Description:</h6>
                    <p class="text-muted">{{ $category->description }}</p>
                </div>
                @endif

                <!-- SEO Information -->
                @if($category->meta_title || $category->meta_description)
                <div class="mb-4">
                    <h6>SEO Information:</h6>
                    @if($category->meta_title)
                        <div class="mb-2">
                            <small class="text-muted">Meta Title:</small>
                            <div>{{ $category->meta_title }}</div>
                        </div>
                    @endif
                    @if($category->meta_description)
                        <div class="mb-2">
                            <small class="text-muted">Meta Description:</small>
                            <div>{{ $category->meta_description }}</div>
                        </div>
                    @endif
                </div>
                @endif

                <!-- Recent Posts -->
                @if($recentPosts->count() > 0)
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6>Recent Posts in this Category</h6>
                        @if($category->posts()->count() > $recentPosts->count())
                            <a href="{{ route('admin.posts.index', ['category' => $category->id]) }}" class="btn btn-sm btn-outline-primary">
                                View All Posts ({{ $category->posts()->count() }})
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
                                By {{ $post->staff->name }} • {{ $post->published_date ?: 'Draft' }}
                                @if($post->is_featured)
                                    <span class="badge bg-warning text-dark ms-1">Featured</span>
                                @endif
                            </div>
                            <p class="mb-0 small text-muted">{{ Str::limit($post->excerpt, 100) }}</p>
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
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">No posts in this category yet</h6>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-1"></i>Create First Post
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
                        <h3 class="text-primary mb-1">{{ $category->posts()->count() }}</h3>
                        <small class="text-muted">Total Posts</small>
                    </div>
                    <div class="col-6 mb-3">
                        <h3 class="text-success mb-1">{{ $category->posts()->where('status', 'published')->count() }}</h3>
                        <small class="text-muted">Published</small>
                    </div>
                    <div class="col-6">
                        <h3 class="text-warning mb-1">{{ $category->posts()->where('status', 'draft')->count() }}</h3>
                        <small class="text-muted">Drafts</small>
                    </div>
                    <div class="col-6">
                        <h3 class="text-info mb-1">{{ $category->sort_order }}</h3>
                        <small class="text-muted">Sort Order</small>
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
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Category
                    </a>

                    <form method="POST" action="{{ route('admin.categories.toggle-status', $category) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-toggle-{{ $category->status === 'active' ? 'on' : 'off' }} me-2"></i>
                            {{ $category->status === 'active' ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>

                    @if($category->posts()->count() > 0)
                    <a href="{{ route('admin.posts.index', ['category' => $category->id]) }}" class="btn btn-outline-info">
                        <i class="fas fa-file-alt me-2"></i>View All Posts
                    </a>
                    @endif

                    <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-success">
                        <i class="fas fa-plus me-2"></i>Create New Post
                    </a>

                    @if($category->posts()->count() === 0)
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirmDelete('Are you sure you want to delete this category?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i>Delete Category
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Category Information -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Name:</label>
                    <div>{{ $category->name }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Slug:</label>
                    <div><code>{{ $category->slug }}</code></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Color:</label>
                    <div class="d-flex align-items-center">
                        <div class="color-preview me-2" style="width: 20px; height: 20px; background-color: {{ $category->color }}; border-radius: 3px; border: 1px solid #ddd;"></div>
                        <code>{{ $category->color }}</code>
                    </div>
                </div>

                @if($category->icon)
                <div class="mb-3">
                    <label class="form-label fw-bold">Icon:</label>
                    <div>
                        <i class="{{ $category->icon }}" style="color: {{ $category->color }}"></i>
                        <code class="ms-2">{{ $category->icon }}</code>
                    </div>
                </div>
                @endif

                <div class="mb-3">
                    <label class="form-label fw-bold">Status:</label>
                    <div>
                        @if($category->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Sort Order:</label>
                    <div>{{ $category->sort_order }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Created:</label>
                    <div>{{ $category->created_at->format('M d, Y \a\t h:i A') }}</div>
                </div>

                @if($category->updated_at != $category->created_at)
                <div class="mb-3">
                    <label class="form-label fw-bold">Last Updated:</label>
                    <div>{{ $category->updated_at->format('M d, Y \a\t h:i A') }}</div>
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
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-folder me-2"></i>All Categories
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>Create New Category
                    </a>
                    @if($category->posts()->count() > 0)
                    <a href="{{ route('blogs.category', $category->slug) }}" target="_blank" class="btn btn-outline-success">
                        <i class="fas fa-external-link-alt me-2"></i>View Live Category
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
