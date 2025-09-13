@extends('admin.layout.app')

@section('title', 'Edit Post: ' . $post->title)
@section('page-title', 'Edit Post')

@section('page-actions')
<div class="d-flex gap-2">
    <a href="{{ route('blog.show', $post) }}" target="_blank" class="btn btn-outline-info">
        <i class="fas fa-external-link-alt me-2"></i>View Post
    </a>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Posts
    </a>
</div>
@endsection

@section('content')
<form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" id="post-form">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $post->title) }}" required onkeyup="generateSlug()">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug', $post->slug) }}">
                        <div class="form-text">Leave empty to auto-generate from title</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Excerpt <span class="text-danger">*</span></label>
                        <textarea name="excerpt" id="excerpt" class="form-control @error('excerpt') is-invalid @enderror"
                                  rows="3" required>{{ old('excerpt', $post->excerpt) }}</textarea>
                        <div class="form-text">Brief description of the post (150-160 characters recommended for SEO)</div>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror"
                                  rows="15" required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Featured Image</label>
                        @if($post->featured_image)
                            <div class="mb-2">
                                <img src="{{ $post->featured_image_url }}" class="img-thumbnail" style="max-width: 200px;" alt="Current featured image">
                                <div class="form-text">Current featured image</div>
                            </div>
                        @endif
                        <input type="file" name="featured_image" id="featured_image"
                               class="form-control @error('featured_image') is-invalid @enderror"
                               accept="image/*" onchange="previewImage(this)">
                        <div class="form-text">Upload a new image to replace the current one</div>
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="image-preview" class="mt-2"></div>
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-search me-2"></i>SEO Settings
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control @error('meta_title') is-invalid @enderror"
                               value="{{ old('meta_title', $post->meta_title) }}" maxlength="60">
                        <div class="form-text">60 characters max. Leave empty to use post title.</div>
                        @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" class="form-control @error('meta_description') is-invalid @enderror"
                                  rows="3" maxlength="160">{{ old('meta_description', $post->meta_description) }}</textarea>
                        <div class="form-text">160 characters max. Leave empty to use excerpt.</div>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="focus_keyword" class="form-label">Focus Keyword</label>
                        <input type="text" name="focus_keyword" id="focus_keyword" class="form-control @error('focus_keyword') is-invalid @enderror"
                               value="{{ old('focus_keyword', $post->focus_keyword) }}">
                        <div class="form-text">Primary keyword you want this post to rank for</div>
                        @error('focus_keyword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror"
                               value="{{ old('meta_keywords', $post->meta_keywords) }}">
                        <div class="form-text">Comma-separated keywords</div>
                        @error('meta_keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="canonical_url" class="form-label">Canonical URL</label>
                        <input type="url" name="canonical_url" id="canonical_url" class="form-control @error('canonical_url') is-invalid @enderror"
                               value="{{ old('canonical_url', $post->canonical_url) }}">
                        <div class="form-text">Leave empty to use default post URL</div>
                        @error('canonical_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Social Media Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-share-alt me-2"></i>Social Media Settings
                    </h5>
                </div>
                <div class="card-body">
                    <h6>Open Graph (Facebook, LinkedIn)</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="og_title" class="form-label">OG Title</label>
                                <input type="text" name="og_title" id="og_title" class="form-control @error('og_title') is-invalid @enderror"
                                       value="{{ old('og_title', $post->og_title) }}">
                                @error('og_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="og_image" class="form-label">OG Image URL</label>
                                <input type="url" name="og_image" id="og_image" class="form-control @error('og_image') is-invalid @enderror"
                                       value="{{ old('og_image', $post->og_image) }}">
                                @error('og_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="og_description" class="form-label">OG Description</label>
                        <textarea name="og_description" id="og_description" class="form-control @error('og_description') is-invalid @enderror"
                                  rows="2">{{ old('og_description', $post->og_description) }}</textarea>
                        @error('og_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <h6 class="mt-4">Twitter Card</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="twitter_title" class="form-label">Twitter Title</label>
                                <input type="text" name="twitter_title" id="twitter_title" class="form-control @error('twitter_title') is-invalid @enderror"
                                       value="{{ old('twitter_title', $post->twitter_title) }}">
                                @error('twitter_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="twitter_image" class="form-label">Twitter Image URL</label>
                                <input type="url" name="twitter_image" id="twitter_image" class="form-control @error('twitter_image') is-invalid @enderror"
                                       value="{{ old('twitter_image', $post->twitter_image) }}">
                                @error('twitter_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="twitter_description" class="form-label">Twitter Description</label>
                        <textarea name="twitter_description" id="twitter_description" class="form-control @error('twitter_description') is-invalid @enderror"
                                  rows="2">{{ old('twitter_description', $post->twitter_description) }}</textarea>
                        @error('twitter_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Post Statistics -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Post Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-primary">{{ number_format($post->views_count) }}</h4>
                                <small class="text-muted">Views</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-success">{{ $post->comments->count() }}</h4>
                                <small class="text-muted">Total Comments</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-info">{{ $post->approvedComments->count() }}</h4>
                                <small class="text-muted">Approved Comments</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-warning">{{ $post->reading_time }}</h4>
                                <small class="text-muted">Min Read</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Publish Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Publish Settings</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status', $post->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="published_at" class="form-label">Publish Date</label>
                        <input type="datetime-local" name="published_at" id="published_at"
                               class="form-control @error('published_at') is-invalid @enderror"
                               value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                        <div class="form-text">Leave empty to publish immediately when status is set to published</div>
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <i class="fas fa-star text-warning me-1"></i>Featured Post
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="allow_comments" id="allow_comments" class="form-check-input" value="1" {{ old('allow_comments', $post->allow_comments) ? 'checked' : '' }}>
                            <label class="form-check-label" for="allow_comments">
                                <i class="fas fa-comments me-1"></i>Allow Comments
                            </label>
                        </div>
                    </div>

                    @if($post->created_at)
                    <div class="mb-3">
                        <label class="form-label">Post Info</label>
                        <div class="small text-muted">
                            <div><strong>Created:</strong> {{ $post->created_at->format('M d, Y \a\t h:i A') }}</div>
                            <div><strong>Updated:</strong> {{ $post->updated_at->format('M d, Y \a\t h:i A') }}</div>
                            @if($post->published_at)
                                <div><strong>Published:</strong> {{ $post->published_at->format('M d, Y \a\t h:i A') }}</div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Author -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Author</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="staff_id" class="form-label">Author <span class="text-danger">*</span></label>
                        <select name="staff_id" id="staff_id" class="form-select @error('staff_id') is-invalid @enderror" required>
                            <option value="">Select Author</option>
                            @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ old('staff_id', $post->staff_id) == $author->id ? 'selected' : '' }}>
                                {{ $author->name }} ({{ $author->position }})
                            </option>
                            @endforeach
                        </select>
                        @error('staff_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Category -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Category</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="post_category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="post_category_id" id="post_category_id" class="form-select @error('post_category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('post_category_id', $post->post_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('post_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tags -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Tags</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Select Tags</label>
                        <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                            @foreach($tags as $tag)
                            <div class="form-check">
                                <input type="checkbox" name="tags[]" id="tag_{{ $tag->id }}" class="form-check-input"
                                       value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tag_{{ $tag->id }}">
                                    <span class="badge" style="background-color: {{ $tag->color }}">{{ $tag->name }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @error('tags')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" name="action" value="save" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Post
                        </button>
                        <button type="submit" name="action" value="save_and_continue" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>Save & Continue Editing
                        </button>
                        <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-outline-info">
                            <i class="fas fa-eye me-2"></i>View Post Details
                        </a>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Posts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
// Initialize TinyMCE
tinymce.init({
    selector: '#content',
    height: 400,
    plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});

// Generate slug from title
function generateSlug() {
    const title = document.getElementById('title').value;
    const slug = title.toLowerCase()
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-');
    document.getElementById('slug').value = slug;
}

// Preview uploaded image
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px;">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

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

// Initialize character counters
updateCharacterCount(document.getElementById('meta_title'), 60);
updateCharacterCount(document.getElementById('meta_description'), 160);
</script>
@endpush
