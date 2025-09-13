@extends('admin.layout.app')

@section('title', 'Categories Management')
@section('page-title', 'Categories Management')

@section('page-actions')
<a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Create New Category
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover" id="categories-table">
                    <thead>
                        <tr>
                            <th width="50">Order</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Color</th>
                            <th>Posts</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-categories">
                        @foreach($categories as $category)
                        <tr data-id="{{ $category->id }}">
                            <td>
                                <span class="badge bg-secondary">{{ $category->sort_order }}</span>
                                <i class="fas fa-grip-vertical text-muted ms-2" style="cursor: grab;"></i>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($category->icon)
                                        <i class="{{ $category->icon }} me-2" style="color: {{ $category->color }}"></i>
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.categories.show', $category) }}" class="text-decoration-none fw-medium">
                                            {{ $category->name }}
                                        </a>
                                        @if($category->description)
                                            <div class="small text-muted">{{ Str::limit($category->description, 60) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <code class="small">{{ $category->slug }}</code>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="color-preview me-2" style="width: 20px; height: 20px; background-color: {{ $category->color }}; border-radius: 3px; border: 1px solid #ddd;"></div>
                                    <code class="small">{{ $category->color }}</code>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold">{{ $category->posts_count }}</span>
                                @if($category->posts_count > 0)
                                    <a href="{{ route('admin.posts.index', ['category' => $category->id]) }}" class="btn btn-sm btn-outline-primary ms-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($category->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                {{ $category->created_at->format('M d, Y') }}
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form method="POST" action="{{ route('admin.categories.toggle-status', $category) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="{{ $category->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-{{ $category->status === 'active' ? 'toggle-on' : 'toggle-off' }}"></i>
                                        </button>
                                    </form>

                                    @if($category->posts_count === 0)
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline" onsubmit="return confirmDelete('Are you sure you want to delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @else
                                    <button class="btn btn-sm btn-outline-danger" disabled title="Cannot delete category with posts">
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
                    Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} categories
                </div>
                {{ $categories->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-folder fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">No categories found</h5>
                <p class="text-muted">Get started by <a href="{{ route('admin.categories.create') }}">creating your first category</a>.</p>
            </div>
        @endif
    </div>
</div>

<!-- Category Order Help -->
<div class="card mt-4">
    <div class="card-body">
        <h6><i class="fas fa-info-circle me-2"></i>Tips:</h6>
        <ul class="mb-0 small text-muted">
            <li>Drag categories to reorder them (affects display order on the frontend)</li>
            <li>Categories with posts cannot be deleted - move or delete posts first</li>
            <li>Use meaningful colors for better visual organization</li>
            <li>Icons use FontAwesome classes (e.g., fas fa-code, fas fa-paint-brush)</li>
        </ul>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
// Make categories sortable
const sortableList = document.getElementById('sortable-categories');
if (sortableList) {
    const sortable = Sortable.create(sortableList, {
        handle: '.fa-grip-vertical',
        animation: 150,
        onEnd: function (evt) {
            updateCategoryOrder();
        }
    });
}

function updateCategoryOrder() {
    const rows = document.querySelectorAll('#sortable-categories tr');
    const categoriesData = [];

    rows.forEach((row, index) => {
        categoriesData.push({
            id: row.dataset.id,
            sort_order: index + 1
        });
    });

    fetch('{{ route("admin.categories.update-order") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            categories: categoriesData
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the order badges
            rows.forEach((row, index) => {
                const badge = row.querySelector('.badge');
                badge.textContent = index + 1;
            });
        }
    })
    .catch(error => {
        console.error('Error updating order:', error);
        alert('Failed to update category order');
    });
}
</script>
@endpush
