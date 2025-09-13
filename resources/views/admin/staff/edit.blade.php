@extends('admin.layout.app')

@section('title', 'Edit Staff: ' . $staff->name)
@section('page-title', 'Edit Staff Member')

@section('page-actions')
<div class="d-flex gap-2">
    <a href="{{ route('admin.staff.show', $staff) }}" class="btn btn-outline-info">
        <i class="fas fa-eye me-2"></i>View Profile
    </a>
    <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Staff
    </a>
</div>
@endsection

@section('content')
<form action="{{ route('admin.staff.update', $staff) }}" method="POST" enctype="multipart/form-data" id="staff-form">
    @csrf
    @method('PUT')

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
                                       value="{{ old('name', $staff->name) }}" required onkeyup="generateSlug()">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $staff->email) }}" required>
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
                                       value="{{ old('slug', $staff->slug) }}">
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
                                       value="{{ old('position', $staff->position) }}" placeholder="e.g., Senior Developer, UI Designer">
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $staff->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio/Description</label>
                        <textarea name="bio" id="bio" class="form-control @error('bio') is-invalid @enderror"
                                  rows="4">{{ old('bio', $staff->bio) }}</textarea>
                        <div class="form-text">Brief description about the staff member</div>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="avatar" class="form-label">Profile Picture</label>
                        @if($staff->avatar)
                            <div class="mb-2">
                                <img src="{{ $staff->avatar_url }}" class="img-thumbnail" style="max-width: 150px;" alt="Current avatar">
                                <div class="form-text">Current profile picture</div>
                            </div>
                        @endif
                        <input type="file" name="avatar" id="avatar"
                               class="form-control @error('avatar') is-invalid @enderror"
                               accept="image/*" onchange="previewImage(this)">
                        <div class="form-text">Upload a new image to replace the current one. Recommended size: 300x300px, max 2MB</div>
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="image-preview" class="mt-2"></div>

                        @if($staff->avatar)
                        <div class="mt-2">
                            <a href="{{ route('admin.staff.remove-avatar', $staff) }}"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Are you sure you want to remove the current avatar?')">
                                <i class="fas fa-times me-1"></i>Remove Current Avatar
                            </a>
                        </div>
                        @endif
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
                                       value="{{ old('social_links.facebook', $staff->social_links['facebook'] ?? '') }}" placeholder="https://facebook.com/username">
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
                                       value="{{ old('social_links.twitter', $staff->social_links['twitter'] ?? '') }}" placeholder="https://twitter.com/username">
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
                                       value="{{ old('social_links.linkedin', $staff->social_links['linkedin'] ?? '') }}" placeholder="https://linkedin.com/in/username">
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
                                       value="{{ old('social_links.instagram', $staff->social_links['instagram'] ?? '') }}" placeholder="https://instagram.com/username">
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
                                       value="{{ old('social_links.github', $staff->social_links['github'] ?? '') }}" placeholder="https://github.com/username">
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
                                       value="{{ old('social_links.dribbble', $staff->social_links['dribbble'] ?? '') }}" placeholder="https://dribbble.com/username">
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
                               value="{{ old('social_links.behance', $staff->social_links['behance'] ?? '') }}" placeholder="https://behance.net/username">
                        @error('social_links.behance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Staff Statistics -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Staff Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h4 class="text-primary">{{ $staff->posts()->count() }}</h4>
                            <small class="text-muted">Total Posts</small>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-success">{{ $staff->posts()->where('status', 'published')->count() }}</h4>
                            <small class="text-muted">Published Posts</small>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-info">{{ $staff->created_at->diffForHumans() }}</h4>
                            <small class="text-muted">Member Since</small>
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
                            <option value="active" {{ old('status', $staff->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $staff->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($staff->created_at)
                    <div class="mb-3">
                        <label class="form-label">Member Info</label>
                        <div class="small text-muted">
                            <div><strong>Joined:</strong> {{ $staff->created_at->format('M d, Y \a\t h:i A') }}</div>
                            <div><strong>Updated:</strong> {{ $staff->updated_at->format('M d, Y \a\t h:i A') }}</div>
                            <div><strong>Posts:</strong> {{ $staff->posts()->count() }} total</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Staff Member
                        </button>

                        <form method="POST" action="{{ route('admin.staff.toggle-status', $staff) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-toggle-{{ $staff->status === 'active' ? 'on' : 'off' }} me-2"></i>
                                {{ $staff->status === 'active' ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        @if($staff->posts()->count() > 0)
                        <a href="{{ route('admin.posts.index', ['author' => $staff->id]) }}" class="btn btn-outline-info">
                            <i class="fas fa-file-alt me-2"></i>View Posts ({{ $staff->posts()->count() }})
                        </a>
                        @endif

                        <a href="{{ route('admin.staff.show', $staff) }}" class="btn btn-outline-info">
                            <i class="fas fa-eye me-2"></i>View Profile
                        </a>

                        <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Staff
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
                    <img id="preview-avatar" src="{{ $staff->avatar_url }}" class="rounded-circle mb-3" width="80" height="80" alt="Preview">
                    <h6 id="preview-name">{{ $staff->name }}</h6>
                    <div id="preview-position" class="text-muted small">{{ $staff->position }}</div>
                    <div id="preview-email" class="text-muted small">{{ $staff->email }}</div>
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
