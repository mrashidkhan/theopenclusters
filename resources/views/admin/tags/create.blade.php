@extends('admin.layout.app')

@section('title', 'Create New Tag')
@section('page-title', 'Create New Tag')

@section('page-actions')
<a href="{{ route('admin.tags.index') }}" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left me-2"></i>Back to Tags
</a>
@endsection

@section('content')
<form action="{{ route('admin.tags.store') }}" method="POST" id="tag-form">
    @csrf

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
                        <div class="form-text">Brief description of this tag</div>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <div class="input-group">
                            <input type="color" name="color" id="color" class="form-control form-control-color @error('color') is-invalid @enderror"
                                   value="{{ old('color', '#6c757d') }}" onchange="updateColorPreview()">
                            <input type="text" id="color-text" class="form-control" value="{{ old('color', '#6c757d') }}"
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
                               value="{{ old('meta_title') }}" maxlength="60">
                        <div class="form-text">60 characters max. Leave empty to use tag name.</div>
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
                            <span id="tag-preview" class="badge" style="background-color: #6c757d;">
                                <span id="preview-text">Tag Name</span>
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
                            <i class="fas fa-save me-2"></i>Create Tag
                        </button>
                        <a href="{{ route('admin.tags.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
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

            <!-- Usage Guidelines -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Tag Guidelines</h6>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <ul class="mb-0">
                            <li>Use lowercase for consistency</li>
                            <li>Keep names short and descriptive</li>
                            <li>Avoid spaces (use hyphens instead)</li>
                            <li>Use relevant technology/topic names</li>
                            <li>Example: laravel, react, javascript, seo</li>
                        </ul>
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

// Initialize preview
updateColorPreview();
</script>
@endpush
