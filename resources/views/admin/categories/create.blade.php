@extends('admin.layout.app')

@section('title', 'Create New Category')
@section('page-title', 'Create New Category')

@section('page-actions')
<a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left me-2"></i>Back to Categories
</a>
@endsection

@section('content')
<form action="{{ route('admin.categories.store') }}" method="POST" id="category-form">
    @csrf

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Category Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required onkeyup="generateSlug()">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug') }}">
                        <div class="form-text">Leave empty to auto-generate from name. Used in URLs.</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="3">{{ old('description') }}</textarea>
                        <div class="form-text">Brief description of this category</div>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="color" class="form-label">Color</label>
                                <div class="input-group">
                                    <input type="color" name="color" id="color" class="form-control form-control-color @error('color') is-invalid @enderror"
                                           value="{{ old('color', '#007bff') }}" onchange="updateColorPreview()">
                                    <input type="text" id="color-text" class="form-control" value="{{ old('color', '#007bff') }}"
                                           onchange="updateColorFromText()" placeholder="#007bff">
                                </div>
                                <div class="form-text">Color used for category badges and identification</div>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="icon" class="form-label">Icon</label>
                                <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror"
                                       value="{{ old('icon') }}" placeholder="fas fa-code">
                                <div class="form-text">FontAwesome icon class (e.g., fas fa-code, fas fa-paint-brush)</div>
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="icon-preview" class="mt-2"></div>
                            </div>
                        </div>
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
                               value="{{ old('meta_title') }}" maxlength="60">
                        <div class="form-text">60 characters max. Leave empty to use category name.</div>
                        @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" class="form-control @error('meta_description') is-invalid @enderror"
                                  rows="3" maxlength="160">{{ old('meta_description') }}</textarea>
                        <div class="form-text">160 characters max. Brief description for search engines.</div>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
                               value="{{ old('sort_order', 0) }}" min="0">
                        <div class="form-text">Lower numbers appear first. Leave 0 for automatic ordering.</div>
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Color Preview -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Preview</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Category Badge Preview:</label>
                        <div>
                            <span id="category-preview" class="badge" style="background-color: #007bff;">
                                <span id="preview-icon"></span>
                                <span id="preview-text">Category Name</span>
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
                            <i class="fas fa-save me-2"></i>Create Category
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Icon Reference -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Common Icons</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="mb-1"><code>fas fa-code</code> - <i class="fas fa-code"></i> Development</div>
                        <div class="mb-1"><code>fas fa-paint-brush</code> - <i class="fas fa-paint-brush"></i> Design</div>
                        <div class="mb-1"><code>fas fa-mobile-alt</code> - <i class="fas fa-mobile-alt"></i> Mobile</div>
                        <div class="mb-1"><code>fas fa-cloud</code> - <i class="fas fa-cloud"></i> Cloud</div>
                        <div class="mb-1"><code>fas fa-shield-alt</code> - <i class="fas fa-shield-alt"></i> Security</div>
                        <div class="mb-1"><code>fas fa-chart-bar</code> - <i class="fas fa-chart-bar"></i> Analytics</div>
                        <div><a href="https://fontawesome.com/icons" target="_blank" class="small">View more icons</a></div>
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
    document.getElementById('preview-text').textContent = name || 'Category Name';
}

// Update color preview
function updateColorPreview() {
    const color = document.getElementById('color').value;
    document.getElementById('color-text').value = color;
    document.getElementById('category-preview').style.backgroundColor = color;
}

// Update color from text input
function updateColorFromText() {
    const colorText = document.getElementById('color-text').value;
    if (/^#[0-9A-F]{6}$/i.test(colorText)) {
        document.getElementById('color').value = colorText;
        document.getElementById('category-preview').style.backgroundColor = colorText;
    }
}

// Update icon preview
function updateIconPreview() {
    const icon = document.getElementById('icon').value;
    const previewIcon = document.getElementById('preview-icon');
    const iconPreview = document.getElementById('icon-preview');

    if (icon) {
        previewIcon.innerHTML = `<i class="${icon} me-1"></i>`;
        iconPreview.innerHTML = `<div class="mt-2"><i class="${icon}" style="color: ${document.getElementById('color').value}"></i> Preview</div>`;
    } else {
        previewIcon.innerHTML = '';
        iconPreview.innerHTML = '';
    }
}

// Event listeners
document.getElementById('name').addEventListener('input', generateSlug);
document.getElementById('color').addEventListener('change', updateColorPreview);
document.getElementById('color-text').addEventListener('input', updateColorFromText);
document.getElementById('icon').addEventListener('input', updateIconPreview);

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

// Initialize preview
updateColorPreview();
updateIconPreview();
</script>
@endpush
