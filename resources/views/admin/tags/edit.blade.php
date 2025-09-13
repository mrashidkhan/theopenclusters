@extends('admin.layout.app')

@section('title', 'Edit Tag: ' . $tag->name)
@section('page-title', 'Edit Tag')

@section('page-actions')
<div class="d-flex gap-2">
    <a href="{{ route('admin.tags.show', $tag) }}" class="btn btn-outline-info">
        <i class="fas fa-eye me-2"></i>View Details
    </a>
    <a href="{{ route('admin.tags.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Tags
    </a>
</div>
@endsection

@section('content')
<form action="{{ route('admin.tags.update', $tag) }}" method="POST" id="tag-form">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Tag Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $tag->name) }}" required onkeyup="generateSlug()">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug', $tag->slug) }}">
                        <div class="form-text">Leave empty to auto-generate from name. Used in URLs.</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="3">{{ old('description', $tag->description) }}</textarea>
                        <div class="form-text">Brief description of this tag</div>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <div class="input-group">
                            <input type="color" name="color" id="color" class="form-control form-control-color @error('color') is-invalid @enderror"
                                   value="{{ old('color', $tag->color) }}" onchange="updateColorPreview()">
                            <input type="text" id="color-text" class="form-control" value="{{ old('color', $tag->color) }}"
                                   onchange="updateColorFromText()" placeholder="#6c757d">
                        </div>
                        <div class="form-text">Color used for tag badges and identification</div>
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-search me-2"></i>SEO Settings
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control @error('meta_title') is-invalid @enderror"
                               value="{{ old('meta_title', $tag->meta_title) }}" maxlength="60">
                        <div class="form-text">60 characters max. Leave empty to use tag name.</div>
                        @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" class="form-control @error('meta_description') is-invalid @enderror"
                                  rows="3" maxlength="160">{{ old('meta_description', $tag->meta_description) }}</textarea>
                        <div class="form-text">160 characters max. Brief description for search engines.</div>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tag Statistics -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Tag Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h4 class="text-primary">{{ $tag->posts()->count() }}</h4>
                            <small class="text-muted">Total Posts</small>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-success">{{ $tag->posts()->where('status', 'published')->count() }}</h4>
                            <small class="text-muted">Published Posts</small>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-info">{{ $tag->created_at->diffForHumans() }}</h4>
                            <small class="text-muted">Created</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Settings -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Settings</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status', $tag->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $tag->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($tag->created_at)
                    <div class="mb-3">
                        <label class="form-label">Tag Info</label>
                        <div class="small text-muted">
                            <div><strong>Created:</strong> {{ $tag->created_at->format('M d, Y \a\t h:i A') }}</div>
                            <div><strong>Updated:</strong> {{ $tag->updated_at->format('M d, Y \a\t h:i A') }}</div>
                            <div><strong>Posts:</strong> {{ $tag->posts()->count() }} total</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Tag Preview -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Preview</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Tag Badge Preview:</label>
                        <div>
                            <span id="tag-preview" class="badge" style="background-color: {{ $tag->color }};">
                                <span id="preview-text">{{ $tag->name }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Tag
                        </button>

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
                            <i class="fas fa-file-alt me-2"></i>View Posts ({{ $tag->posts()->count() }})
                        </a>
                        @endif

                        <a href="{{ route('admin.tags.show', $tag) }}" class="btn btn-outline-info">
                            <i class="fas fa-eye me-2"></i>View Details
                        </a>

                        <a href="{{ route('admin.tags.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Tags
                        </a>
                    </div>
                </div>
            </div>

            <!-- Color Suggestions -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Color Suggestions</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-sm border" style="background-color: #007bff;" onclick="setColor('#007bff')" title="Blue"></button>
                        <button type="button" class="btn btn-sm border" style="background-color: #28a745;" onclick="setColor('#28a745')" title="Green"></button>
                        <button type="button" class="btn btn-sm border" style="background-color: #dc3545;" onclick="setColor('#dc3545')" title="Red"></button>
                        <button type="button" class="btn btn-sm border" style="background-color: #ffc107;" onclick="setColor('#ffc107')" title="Yellow"></button>
                        <button type="button" class="btn btn-sm border" style="background-color: #6f42c1;" onclick="setColor('#6f42c1')" title="Purple"></button>
                        <button type="button" class="btn btn-sm border" style="background-color: #fd7e14;" onclick="setColor('#fd7e14')" title="Orange"></button>
                        <button type="button" class="btn btn-sm border" style="background-color: #20c997;" onclick="setColor('#20c997')" title="Teal"></button>
                        <button type="button" class="btn btn-sm border" style="background-color: #e83e8c;" onclick="setColor('#e83e8c')" title="Pink"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
// Generate slug from name
function generateSlug() {
    const name = document.getElementById('name').value;
    const slug = name.toLowerCase()
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-');
    document.getElementById('slug').value = slug;

    // Update preview
    document.getElementById('preview-text').textContent = name || 'Tag Name';
}

// Update color preview
function updateColorPreview() {
    const color = document.getElementById('color').value;
    document.getElementById('color-text').value = color;
    document.getElementById('tag-preview').style.backgroundColor = color;
}

// Update color from text input
function updateColorFromText() {
    const colorText = document.getElementById('color-text').value;
    if (/^#[0-9A-F]{6}$/i.test(colorText)) {
        document.getElementById('color').value = colorText;
        document.getElementById('tag-preview').style.backgroundColor = colorText;
    }
}

// Set color from suggestion
function setColor(color) {
    document.getElementById('color').value = color;
    document.getElementById('color-text').value = color;
    document.getElementById('tag-preview').style.backgroundColor = color;
}

// Event listeners
document.getElementById('name').addEventListener('input', generateSlug);
document.getElementById('color').addEventListener('change', updateColorPreview);
document.getElementById('color-text').addEventListener('input', updateColorFromText);

// Character counters
document.getElementById('meta_title').addEventListener('input', function() {
    updateCharacterCount(this, 60);
});

document.getElementById('meta_description').addEventListener('input', function() {
    updateCharacterCount(this, 160);
});

function updateCharacterCount(element, maxLength) {
    const current = element.value.length;
    const remaining = maxLength - current;
    const color = remaining < 0 ? 'text-danger' : (remaining < 20 ? 'text-warning' : 'text-muted');

    let counter = element.parentNode.querySelector('.char-counter');
    if (!counter) {
        counter = document.createElement('div');
        counter.className = 'char-counter form-text';
        element.parentNode.appendChild(counter);
    }

    counter.className = `char-counter form-text ${color}`;
    counter.textContent = `${current}/${maxLength} characters`;
}

// Initialize
updateCharacterCount(document.getElementById('meta_title'), 60);
updateCharacterCount(document.getElementById('meta_description'), 160);
</script>
@endpush
