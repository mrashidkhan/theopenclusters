@extends('admin.layout.app')

@section('title', 'Add New Staff Member')
@section('page-title', 'Add New Staff Member')

@section('page-actions')
<a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left me-2"></i>Back to Staff
</a>
@endsection

@section('content')
<form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data" id="staff-form">
    @csrf

    <div class="row">
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required onkeyup="generateSlug()">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug" class="form-label">URL Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                                       value="{{ old('slug') }}">
                                <div class="form-text">Leave empty to auto-generate from name</div>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="position" class="form-label">Position/Title</label>
                                <input type="text" name="position" id="position" class="form-control @error('position') is-invalid @enderror"
                                       value="{{ old('position') }}" placeholder="e.g., Senior Developer, UI Designer">
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio/Description</label>
                        <textarea name="bio" id="bio" class="form-control @error('bio') is-invalid @enderror"
                                  rows="4">{{ old('bio') }}</textarea>
                        <div class="form-text">Brief description about the staff member</div>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="avatar" class="form-label">Profile Picture</label>
                        <input type="file" name="avatar" id="avatar"
                               class="form-control @error('avatar') is-invalid @enderror"
                               accept="image/*" onchange="previewImage(this)">
                        <div class="form-text">Recommended size: 300x300px, max 2MB</div>
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="image-preview" class="mt-2"></div>
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-share-alt me-2"></i>Social Media Links
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="facebook" class="form-label">
                                    <i class="fab fa-facebook me-2"></i>Facebook
                                </label>
                                <input type="url" name="social_links[facebook]" id="facebook"
                                       class="form-control @error('social_links.facebook') is-invalid @enderror"
                                       value="{{ old('social_links.facebook') }}" placeholder="https://facebook.com/username">
                                @error('social_links.facebook')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="twitter" class="form-label">
                                    <i class="fab fa-twitter me-2"></i>Twitter
                                </label>
                                <input type="url" name="social_links[twitter]" id="twitter"
                                       class="form-control @error('social_links.twitter') is-invalid @enderror"
                                       value="{{ old('social_links.twitter') }}" placeholder="https://twitter.com/username">
                                @error('social_links.twitter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="linkedin" class="form-label">
                                    <i class="fab fa-linkedin me-2"></i>LinkedIn
                                </label>
                                <input type="url" name="social_links[linkedin]" id="linkedin"
                                       class="form-control @error('social_links.linkedin') is-invalid @enderror"
                                       value="{{ old('social_links.linkedin') }}" placeholder="https://linkedin.com/in/username">
                                @error('social_links.linkedin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="instagram" class="form-label">
                                    <i class="fab fa-instagram me-2"></i>Instagram
                                </label>
                                <input type="url" name="social_links[instagram]" id="instagram"
                                       class="form-control @error('social_links.instagram') is-invalid @enderror"
                                       value="{{ old('social_links.instagram') }}" placeholder="https://instagram.com/username">
                                @error('social_links.instagram')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="github" class="form-label">
                                    <i class="fab fa-github me-2"></i>GitHub
                                </label>
                                <input type="url" name="social_links[github]" id="github"
                                       class="form-control @error('social_links.github') is-invalid @enderror"
                                       value="{{ old('social_links.github') }}" placeholder="https://github.com/username">
                                @error('social_links.github')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dribbble" class="form-label">
                                    <i class="fab fa-dribbble me-2"></i>Dribbble
                                </label>
                                <input type="url" name="social_links[dribbble]" id="dribbble"
                                       class="form-control @error('social_links.dribbble') is-invalid @enderror"
                                       value="{{ old('social_links.dribbble') }}" placeholder="https://dribbble.com/username">
                                @error('social_links.dribbble')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="behance" class="form-label">
                            <i class="fab fa-behance me-2"></i>Behance
                        </label>
                        <input type="url" name="social_links[behance]" id="behance"
                               class="form-control @error('social_links.behance') is-invalid @enderror"
                               value="{{ old('social_links.behance') }}" placeholder="https://behance.net/username">
                        @error('social_links.behance')
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

            <!-- Actions -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Create Staff Member
                        </button>
                        <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Preview</h6>
                </div>
                <div class="card-body text-center">
                    <img id="preview-avatar" src="{{ asset('img/admin.jpg') }}" class="rounded-circle mb-3" width="80" height="80" alt="Preview">
                    <h6 id="preview-name">Staff Name</h6>
                    <div id="preview-position" class="text-muted small">Position</div>
                    <div id="preview-email" class="text-muted small">email@example.com</div>
                </div>
            </div>

            <!-- Guidelines -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Guidelines</h6>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <ul class="mb-0">
                            <li>Use professional profile pictures</li>
                            <li>Keep bio concise and informative</li>
                            <li>Add relevant social media links</li>
                            <li>Use descriptive position titles</li>
                            <li>Ensure email addresses are valid</li>
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
    document.getElementById('preview-name').textContent = name || 'Staff Name';
}

// Preview uploaded image
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const previewAvatar = document.getElementById('preview-avatar');

    preview.innerHTML = '';

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px;">`;
            previewAvatar.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Update preview
function updatePreview() {
    const name = document.getElementById('name').value;
    const position = document.getElementById('position').value;
    const email = document.getElementById('email').value;

    document.getElementById('preview-name').textContent = name || 'Staff Name';
    document.getElementById('preview-position').textContent = position || 'Position';
    document.getElementById('preview-email').textContent = email || 'email@example.com';
}

// Event listeners
document.getElementById('name').addEventListener('input', function() {
    generateSlug();
    updatePreview();
});

document.getElementById('position').addEventListener('input', updatePreview);
document.getElementById('email').addEventListener('input', updatePreview);

// Initialize preview
updatePreview();
</script>
@endpush
