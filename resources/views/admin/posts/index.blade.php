@extends('admin.layout.app')

@section('title', 'Posts Management')
@section('page-title', 'Posts Management')

@section('page-actions')
<a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Create New Post
</a>
@endsection

@section('content')
<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.posts.index') }}" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search posts..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="author" class="form-select">
                    <option value="">All Authors</option>
                    @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                        {{ $author->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="fas fa-search me-1"></i>Filter
                </button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Posts Table -->
<div class="card">
    <div class="card-body">
        @if($posts->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="select-all" onchange="toggleSelectAll(this)">
                            </th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Comments</th>
                            <th>Date</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td>
                                <input type="checkbox" name="items[]" value="{{ $post->id }}" onchange="updateBulkActions()">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($post->featured_image)
                                        <img src="{{ $post->featured_image_url }}" class="rounded me-3" width="40" height="40" style="object-fit: cover;" alt="">
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.posts.show', $post) }}" class="text-decoration-none fw-medium">
                                            {{ Str::limit($post->title, 50) }}
                                        </a>
                                        @if($post->is_featured)
                                            <span class="badge featured-badge ms-2">
                                                <i class="fas fa-star me-1"></i>Featured
                                            </span>
                                        @endif
                                        <div class="small text-muted mt-1">
                                            <a href="{{ route('blog.show', $post) }}" target="_blank" class="text-muted text-decoration-none">
                                                <i class="fas fa-external-link-alt me-1"></i>View Post
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $post->staff->avatar_url }}" class="rounded-circle me-2" width="30" height="30" alt="">
                                    <span>{{ $post->staff->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background-color: {{ $post->category->color }}">
                                    {{ $post->category->name }}
                                </span>
                            </td>
                            <td>
                                @if($post->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                @elseif($post->status === 'draft')
                                    <span class="badge bg-secondary">Draft</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ ucfirst($post->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold">{{ number_format($post->views_count) }}</span>
                            </td>
                            <td>
                                <span class="fw-bold">{{ $post->approvedComments->count() }}</span>
                                @if($post->comments->where('status', 'pending')->count() > 0)
                                    <span class="badge bg-warning text-dark ms-1">
                                        {{ $post->comments->where('status', 'pending')->count() }} pending
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="small">
                                    <div>{{ $post->created_at->format('M d, Y') }}</div>
                                    @if($post->published_at)
                                        <div class="text-muted">Pub: {{ $post->published_at->format('M d') }}</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Quick Actions -->
                                    <form method="POST" action="{{ route('admin.posts.toggle-status', $post) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="{{ $post->status === 'published' ? 'Unpublish' : 'Publish' }}">
                                            <i class="fas fa-{{ $post->status === 'published' ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.posts.toggle-featured', $post) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-warning" title="{{ $post->is_featured ? 'Remove from Featured' : 'Make Featured' }}">
                                            <i class="fas fa-star{{ $post->is_featured ? '' : '-o' }}"></i>
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

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
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
                    <div class="col-md-3">
                        <select name="action" class="form-select" required>
                            <option value="">Select Action</option>
                            <option value="publish">Publish</option>
                            <option value="draft">Move to Draft</option>
                            <option value="archive">Archive</option>
                            <option value="delete">Delete</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Apply to Selected</button>
                        <button type="button" class="btn btn-secondary ms-2" onclick="clearSelection()">Cancel</button>
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
