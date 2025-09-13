@extends('admin.layout.app')

@section('title', 'Comments Management')
@section('page-title', 'Comments Management')

@section('page-actions')
<div class="d-flex gap-2">
    <a href="{{ route('admin.comments.pending') }}" class="btn btn-warning">
        <i class="fas fa-clock me-2"></i>Pending Comments
        @php
            $pendingCount = \App\Models\PostComment::where('status', 'pending')->count();
        @endphp
        @if($pendingCount > 0)
            <span class="badge bg-danger ms-1">{{ $pendingCount }}</span>
        @endif
    </a>
    <a href="{{ route('admin.comments.spam') }}" class="btn btn-outline-danger">
        <i class="fas fa-exclamation-triangle me-2"></i>Spam Comments
    </a>
</div>
@endsection

@section('content')
<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.comments.index') }}" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search comments..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="spam" {{ request('status') === 'spam' ? 'selected' : '' }}>Spam</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="post" class="form-select">
                    <option value="">All Posts</option>
                    @foreach($posts as $post)
                    <option value="{{ $post->id }}" {{ request('post') == $post->id ? 'selected' : '' }}>
                        {{ Str::limit($post->title, 50) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="fas fa-search me-1"></i>Filter
                </button>
                <a href="{{ route('admin.comments.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Comments Table -->
<div class="card">
    <div class="card-body">
        @if($comments->count() > 0)
            <!-- Bulk Actions -->
            <div class="bulk-actions mb-3" style="display: none;">
                <form method="POST" action="{{ route('admin.comments.bulk-action') }}" onsubmit="return confirm('Are you sure you want to perform this action on selected comments?')" class="d-inline">
                    @csrf
                    <input type="hidden" name="comments" id="bulk-comments">
                    <div class="d-flex align-items-center gap-2">
                        <select name="action" class="form-select" style="width: auto;" required>
                            <option value="">Select Action</option>
                            <option value="approve">Approve</option>
                            <option value="reject">Reject</option>
                            <option value="spam">Mark as Spam</option>
                            <option value="delete">Delete</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="clearSelection()">Cancel</button>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="select-all" onchange="toggleSelectAll(this)">
                            </th>
                            <th>Author</th>
                            <th>Comment</th>
                            <th>Post</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comments as $comment)
                        <tr class="{{ $comment->status === 'pending' ? 'table-warning' : ($comment->status === 'spam' ? 'table-danger' : '') }}">
                            <td>
                                <input type="checkbox" name="items[]" value="{{ $comment->id }}" onchange="updateBulkActions()">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $comment->avatar }}" class="rounded-circle me-2" width="32" height="32" alt="">
                                    <div>
                                        <h6 class="mb-1">{{ $comment->name }}</h6>
                                        <small class="text-muted">{{ $comment->email }}</small>
                                        @if($comment->website)
                                            <div><a href="{{ $comment->website }}" target="_blank" class="small text-muted">{{ $comment->website }}</a></div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-1">{{ Str::limit($comment->content, 100) }}</p>
                                @if($comment->parent_id)
                                    <small class="text-muted">
                                        <i class="fas fa-reply me-1"></i>Reply to {{ $comment->parent->name }}
                                    </small>
                                @endif
                                @if($comment->is_featured)
                                    <span class="badge bg-warning text-dark ms-2">Featured</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.posts.show', $comment->post) }}" class="text-decoration-none">
                                    {{ Str::limit($comment->post->title, 40) }}
                                </a>
                            </td>
                            <td>
                                @if($comment->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($comment->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($comment->status === 'spam')
                                    <span class="badge bg-danger">Spam</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($comment->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="small">
                                    <div>{{ $comment->created_at->format('M d, Y') }}</div>
                                    <div class="text-muted">{{ $comment->created_at->format('h:i A') }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.comments.show', $comment) }}" class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @if($comment->status === 'pending')
                                    <form method="POST" action="{{ route('admin.comments.approve', $comment) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif

                                    @if($comment->status !== 'spam')
                                    <form method="POST" action="{{ route('admin.comments.spam', $comment) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-warning" title="Mark as Spam">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </button>
                                    </form>
                                    @endif

                                    <a href="{{ route('admin.comments.edit', $comment) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" class="d-inline" onsubmit="return confirmDelete('Are you sure you want to delete this comment?')">
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
                    Showing {{ $comments->firstItem() }} to {{ $comments->lastItem() }} of {{ $comments->total() }} comments
                </div>
                {{ $comments->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-comments fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">No comments found</h5>
                <p class="text-muted">
                    @if(request()->hasAny(['search', 'status', 'post']))
                        Try adjusting your filters or <a href="{{ route('admin.comments.index') }}">view all comments</a>.
                    @else
                        Comments will appear here when users start commenting on your posts.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

<!-- Comment Statistics -->
@if($comments->total() > 0)
<div class="card mt-4">
    <div class="card-header">
        <h6 class="card-title mb-0">Comment Statistics</h6>
    </div>
    <div class="card-body">
        <div class="row text-center">
            @php
                $totalComments = \App\Models\PostComment::count();
                $approvedComments = \App\Models\PostComment::where('status', 'approved')->count();
                $pendingComments = \App\Models\PostComment::where('status', 'pending')->count();
                $spamComments = \App\Models\PostComment::where('status', 'spam')->count();
            @endphp
            <div class="col-md-3">
                <h4 class="text-primary">{{ $totalComments }}</h4>
                <small class="text-muted">Total Comments</small>
            </div>
            <div class="col-md-3">
                <h4 class="text-success">{{ $approvedComments }}</h4>
                <small class="text-muted">Approved</small>
            </div>
            <div class="col-md-3">
                <h4 class="text-warning">{{ $pendingComments }}</h4>
                <small class="text-muted">Pending</small>
            </div>
            <div class="col-md-3">
                <h4 class="text-danger">{{ $spamComments }}</h4>
                <small class="text-muted">Spam</small>
            </div>
        </div>
    </div>
</div>
@endif
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

function updateBulkActions() {
    const checkboxes = document.querySelectorAll('input[name="items[]"]:checked');
    const bulkActions = document.querySelector('.bulk-actions');
    const bulkCommentsInput = document.getElementById('bulk-comments');

    if (bulkActions) {
        bulkActions.style.display = checkboxes.length > 0 ? 'block' : 'none';
    }

    if (bulkCommentsInput) {
        const commentIds = Array.from(checkboxes).map(cb => cb.value);
        bulkCommentsInput.value = JSON.stringify(commentIds);
    }
}

function toggleSelectAll(selectAllCheckbox) {
    const checkboxes = document.querySelectorAll('input[name="items[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateBulkActions();
}
</script>
@endpush
