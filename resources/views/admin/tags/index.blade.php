@extends('admin.layout.app')

@section('title', 'Tags Management')
@section('page-title', 'Tags Management')

@section('page-actions')
<a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Create New Tag
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if($tags->count() > 0)
            <!-- Bulk Actions -->
            <div class="bulk-actions mb-3" style="display: none;">
                <div class="d-flex align-items-center">
                    <form method="POST" action="{{ route('admin.tags.bulk-delete') }}" onsubmit="return confirmDelete('Are you sure you want to delete selected tags?')" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="tags" id="bulk-tags">
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash me-2"></i>Delete Selected
                        </button>
                    </form>
                    <button type="button" class="btn btn-secondary btn-sm ms-2" onclick="clearSelection()">Cancel</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="select-all" onchange="toggleSelectAll(this)">
                            </th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Color</th>
                            <th>Posts</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tags as $tag)
                        <tr>
                            <td>
                                <input type="checkbox" name="items[]" value="{{ $tag->id }}" onchange="updateBulkActions()">
                            </td>
                            <td>
                                <div>
                                    <a href="{{ route('admin.tags.show', $tag) }}" class="text-decoration-none fw-medium">
                                        {{ $tag->name }}
                                    </a>
                                    @if($tag->description)
                                        <div class="small text-muted">{{ Str::limit($tag->description, 60) }}</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <code class="small">{{ $tag->slug }}</code>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="color-preview me-2" style="width: 20px; height: 20px; background-color: {{ $tag->color }}; border-radius: 3px; border: 1px solid #ddd;"></div>
                                    <span class="badge" style="background-color: {{ $tag->color }}">{{ $tag->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold">{{ $tag->posts_count }}</span>
                                @if($tag->posts_count > 0)
                                    <a href="{{ route('admin.posts.index', ['tag' => $tag->id]) }}" class="btn btn-sm btn-outline-primary ms-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($tag->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                {{ $tag->created_at->format('M d, Y') }}
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.tags.show', $tag) }}" class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form method="POST" action="{{ route('admin.tags.toggle-status', $tag) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="{{ $tag->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-{{ $tag->status === 'active' ? 'toggle-on' : 'toggle-off' }}"></i>
                                        </button>
                                    </form>

                                    @if($tag->posts_count === 0)
                                    <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" class="d-inline" onsubmit="return confirmDelete('Are you sure you want to delete this tag?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @else
                                    <button class="btn btn-sm btn-outline-danger" disabled title="Cannot delete tag with posts">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
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
                    Showing {{ $tags->firstItem() }} to {{ $tags->lastItem() }} of {{ $tags->total() }} tags
                </div>
                {{ $tags->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">No tags found</h5>
                <p class="text-muted">Get started by <a href="{{ route('admin.tags.create') }}">creating your first tag</a>.</p>
            </div>
        @endif
    </div>
</div>

<!-- Tags Usage Stats -->
@if($tags->count() > 0)
<div class="card mt-4">
    <div class="card-header">
        <h6 class="card-title mb-0">Tag Usage Statistics</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 text-center">
                <h4 class="text-primary">{{ $tags->where('status', 'active')->count() }}</h4>
                <small class="text-muted">Active Tags</small>
            </div>
            <div class="col-md-3 text-center">
                <h4 class="text-success">{{ $tags->where('posts_count', '>', 0)->count() }}</h4>
                <small class="text-muted">Tags with Posts</small>
            </div>
            <div class="col-md-3 text-center">
                <h4 class="text-warning">{{ $tags->where('posts_count', 0)->count() }}</h4>
                <small class="text-muted">Unused Tags</small>
            </div>
            <div class="col-md-3 text-center">
                <h4 class="text-info">{{ $tags->sum('posts_count') }}</h4>
                <small class="text-muted">Total Tag Usage</small>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Tips -->
<div class="card mt-4">
    <div class="card-body">
        <h6><i class="fas fa-info-circle me-2"></i>Tips:</h6>
        <ul class="mb-0 small text-muted">
            <li>Tags help organize content and improve discoverability</li>
            <li>Use descriptive and relevant tag names</li>
            <li>Tags with posts cannot be deleted - remove from posts first</li>
            <li>Choose consistent colors for better visual organization</li>
            <li>Tags can be used for filtering and searching posts</li>
        </ul>
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

function updateBulkActions() {
    const checkboxes = document.querySelectorAll('input[name="items[]"]:checked');
    const bulkActions = document.querySelector('.bulk-actions');
    const bulkTagsInput = document.getElementById('bulk-tags');

    if (bulkActions) {
        bulkActions.style.display = checkboxes.length > 0 ? 'block' : 'none';
    }

    if (bulkTagsInput) {
        const tagIds = Array.from(checkboxes).map(cb => cb.value);
        bulkTagsInput.value = JSON.stringify(tagIds);
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
