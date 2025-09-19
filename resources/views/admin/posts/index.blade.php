@extends('admin.layout.app')

@section('title', 'Posts Management')
@section('page-title', 'Posts Management')

@section('page-actions')
<a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i><span class="d-none d-sm-inline">Create New Post</span><span class="d-sm-none">New</span>
</a>
@endsection

@push('styles')
<style>
    /* Sidebar heading visibility fix */
        .sidebar .sidebar-heading {
            color: #16C60C !important;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

/* Ultra Compact Filter Styles */
.filters-mobile {
    margin: 0;
}

.filters-mobile .form-control-sm,
.filters-mobile .form-select-sm {
    font-size: 0.7rem;
    padding: 0.25rem 0.375rem;
    height: 28px;
}



.filters-mobile .btn-sm {
    padding: 0.25rem 0.375rem;
    font-size: 0.7rem;
    height: 28px;
}

.compact-filter-card {
    padding: 0.5rem !important;
}

@media (max-width: 1200px) {
    .filters-mobile .form-control-sm,
    .filters-mobile .form-select-sm {
        font-size: 0.65rem;
        padding: 0.2rem 0.3rem;
        height: 24px;
    }

    .filters-mobile .btn-sm {
        padding: 0.2rem 0.3rem;
        font-size: 0.65rem;
        height: 24px;
    }
}

/* Ultra Compact Table Styles */
.minimal-posts-table {
    font-size: 0.85rem;
    margin-bottom: 0;
}

.minimal-posts-table th,
.minimal-posts-table td {
    padding: 0.5rem 0.375rem;
    vertical-align: middle;
    border-bottom: 1px solid #dee2e6;
}

.minimal-posts-table th {
    font-size: 0.8rem;
    font-weight: 600;
    background-color: #f8f9fa;
}

.minimal-posts-table .table-actions {
    white-space: nowrap;
}

.minimal-posts-table .table-actions .btn {
    padding: 0.2rem 0.35rem;
    margin: 0 0.05rem;
    font-size: 0.7rem;
    border-width: 1px;
}

.post-title-cell {
    width: 55%;
    max-width: 0;
}

.post-status-cell {
    width: 12%;
}

.post-actions-cell {
    width: 28%;
}

.checkbox-cell {
    width: 5%;
}

.post-image-thumb {
    width: 30px;
    height: 30px;
    object-fit: cover;
    border-radius: 0.25rem;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .mobile-card {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
        background: #fff;
    }

    .mobile-card-body {
        padding: 1rem;
    }

    .mobile-actions {
        padding: 0.75rem 1rem;
        border-top: 1px solid #dee2e6;
        background-color: #f8f9fa;
        border-radius: 0 0 0.375rem 0.375rem;
    }

    .mobile-actions .btn {
        padding: 0.375rem 0.75rem;
        margin: 0.125rem;
        font-size: 0.875rem;
    }

    .mobile-title {
        font-size: 1.1rem;
        margin-bottom: 0.75rem;
    }

    .mobile-status {
        margin-bottom: 1rem;
    }

    .filters-mobile .col-md-3,
    .filters-mobile .col-md-2 {
        margin-bottom: 0.75rem;
    }
}

@media (max-width: 576px) {
    .mobile-actions .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    .mobile-actions .btn span {
        display: none;
    }

    .mobile-card-body {
        padding: 0.75rem;
    }
}
</style>
@endpush

@section('content')
<!-- Super Compact Filters -->
<div class="card mb-3">
    <div class="card-body compact-filter-card">
        <form method="GET" action="{{ route('admin.posts.index') }}" class="row g-1 filters-mobile">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="{{ request('search') }}">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Pub</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Arc</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3">
                <select name="category" class="form-select form-select-sm">
                    <option value="">Cat</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ Str::limit($category->name, 8) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6">
                <select name="author" class="form-select form-select-sm">
                    <option value="">Author</option>
                    @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                        {{ Str::limit($author->name, 8) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3 col-md-2 col-12">
                <div class="d-flex gap-1">
                    <button type="submit" class="btn btn-outline-primary btn-sm flex-fill">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Posts Content -->
<div class="card">
    <div class="card-body">
        @if($posts->count() > 0)
            <!-- Desktop/Tablet Table View -->
            <div class="d-none d-md-block">
                <div class="table-responsive">
                    <table class="table table-hover minimal-posts-table">
                        <thead>
                            <tr>
                                <th class="checkbox-cell">
                                    <input type="checkbox" id="select-all" onchange="toggleSelectAll(this)">
                                </th>
                                <th class="post-title-cell">Title</th>
                                <th class="post-status-cell">Status</th>
                                <th class="post-actions-cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr>
                                <td class="checkbox-cell">
                                    <input type="checkbox" name="items[]" value="{{ $post->id }}" onchange="updateBulkActions()">
                                </td>
                                <td class="post-title-cell">
                                    <div class="d-flex align-items-center">
                                        @if($post->featured_image)
                                            <img src="{{ $post->featured_image_url }}" class="post-image-thumb me-2" alt="">
                                        @endif
                                        <div class="flex-grow-1 min-w-0">
                                            <a href="{{ route('admin.posts.show', $post) }}" class="text-decoration-none fw-medium d-block text-truncate" title="{{ $post->title }}">
                                                {{ Str::limit($post->title, 45) }}
                                            </a>
                                            @if($post->is_featured)
                                                <span class="badge bg-warning text-dark" style="font-size: 0.65rem;">
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            @endif
                                            <div class="small text-muted" style="font-size: 0.7rem;">
                                                {{ Str::limit($post->staff->name, 15) }} • {{ $post->created_at->format('M d') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="post-status-cell">
                                    @if($post->status === 'published')
                                        <span class="badge bg-success" style="font-size: 0.7rem;">Pub</span>
                                    @elseif($post->status === 'draft')
                                        <span class="badge bg-secondary" style="font-size: 0.7rem;">Draft</span>
                                    @else
                                        <span class="badge bg-warning text-dark" style="font-size: 0.7rem;">{{ ucfirst($post->status) }}</span>
                                    @endif
                                </td>
                                <td class="post-actions-cell">
                                    <div class="table-actions">
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.posts.toggle-status', $post) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-secondary" title="{{ $post->status === 'published' ? 'Unpublish' : 'Publish' }}">
                                                <i class="fas fa-{{ $post->status === 'published' ? 'eye-slash' : 'eye' }}"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="d-inline" onsubmit="return confirmDelete('Are you sure you want to delete this post?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div class="d-md-none">
                @foreach($posts as $post)
                <div class="mobile-card">
                    <div class="mobile-card-body">
                        <div class="d-flex align-items-start mb-3">
                            <input type="checkbox" name="items[]" value="{{ $post->id }}" class="me-2 mt-1" onchange="updateBulkActions()">
                            @if($post->featured_image)
                                <img src="{{ $post->featured_image_url }}" class="rounded me-3" width="60" height="60" style="object-fit: cover;" alt="">
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mobile-title mb-2">
                                    <a href="{{ route('admin.posts.show', $post) }}" class="text-decoration-none">
                                        {{ $post->title }}
                                    </a>
                                </h6>
                                @if($post->is_featured)
                                    <span class="badge featured-badge mb-2">
                                        <i class="fas fa-star me-1"></i>Featured
                                    </span>
                                @endif
                                <div class="small text-muted mb-2">
                                    <div>By {{ $post->staff->name }}</div>
                                    <div>{{ $post->category->name }} • {{ $post->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mobile-status">
                            @if($post->status === 'published')
                                <span class="badge bg-success">Published</span>
                            @elseif($post->status === 'draft')
                                <span class="badge bg-secondary">Draft</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ ucfirst($post->status) }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mobile-actions">
                        <div class="d-flex flex-wrap gap-1">
                            <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i><span class="ms-1">View</span>
                            </a>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i><span class="ms-1">Edit</span>
                            </a>
                            <a href="{{ route('blog.show', $post) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-external-link-alt"></i><span class="ms-1">Live</span>
                            </a>
                            <form method="POST" action="{{ route('admin.posts.toggle-status', $post) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-{{ $post->status === 'published' ? 'eye-slash' : 'eye' }}"></i>
                                    <span class="ms-1">{{ $post->status === 'published' ? 'Hide' : 'Pub' }}</span>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="d-inline" onsubmit="return confirmDelete('Are you sure you want to delete this post?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i><span class="ms-1">Del</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-4">
                <div class="text-muted mb-2 mb-sm-0">
                    Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} posts
                </div>
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">No posts found</h5>
                <p class="text-muted">
                    @if(request()->hasAny(['search', 'status', 'category', 'author']))
                        Try adjusting your filters or <a href="{{ route('admin.posts.index') }}">view all posts</a>.
                    @else
                        Get started by <a href="{{ route('admin.posts.create') }}">creating your first post</a>.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

<!-- Bulk Actions (hidden by default) -->
<div class="bulk-actions mt-3" style="display: none;">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.posts.bulk-action') }}" onsubmit="return confirm('Are you sure you want to perform this action on selected posts?')">
                @csrf
                <div class="row align-items-center">
                    <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                        <select name="action" class="form-select" required>
                            <option value="">Select Action</option>
                            <option value="publish">Publish</option>
                            <option value="draft">Move to Draft</option>
                            <option value="archive">Archive</option>
                            <option value="delete">Delete</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <button type="submit" class="btn btn-primary w-100">Apply to Selected</button>
                    </div>
                    <div class="col-12 col-sm-auto mt-2 mt-sm-0">
                        <button type="button" class="btn btn-secondary w-100 w-sm-auto" onclick="clearSelection()">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function clearSelection() {
    document.querySelectorAll('input[name="items[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('select-all').checked = false;
    updateBulkActions();
}
</script>
@endpush
