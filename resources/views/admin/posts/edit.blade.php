@extends('admin.layout.app')

@section('title', 'Edit Post: ' . $post->title)
@section('page-title', 'Edit Post')

@section('page-actions')
<div class="d-flex gap-2 flex-wrap">
    <a href="{{ route('blog.show', $post) }}" target="_blank" class="btn btn-outline-info">
        <i class="fas fa-external-link-alt me-2"></i><span class="d-none d-sm-inline">View Post</span><span class="d-sm-none">View</span>
    </a>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i><span class="d-none d-sm-inline">Back to Posts</span><span class="d-sm-none">Back</span>
    </a>
</div>
@endsection

@push('styles')
<!-- Include Quill.js CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
/* Mobile Responsive Styles */
@media (max-width: 992px) {
    .sidebar-sticky {
        position: relative !important;
        height: auto !important;
    }

    .mobile-sidebar-card {
        margin-bottom: 1rem;
    }

    .mobile-main-content {
        margin-bottom: 2rem;
    }
}

@media (max-width: 768px) {
    .quill-editor-container .ql-toolbar {
        padding: 0.5rem;
    }

    .quill-editor-container .ql-editor {
        min-height: 200px;
        padding: 0.75rem;
    }

    .form-control, .form-select {
        font-size: 16px; /* Prevents zoom on iOS */
    }

    .card-header h5 {
        font-size: 1.1rem;
    }

    .btn {
        padding: 0.5rem 1rem;
    }

    .page-actions {
        margin-bottom: 1rem;
    }

    .mobile-action-buttons {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        border-top: 1px solid #dee2e6;
        padding: 1rem;
        z-index: 1020;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
    }

    .mobile-action-buttons .btn {
        font-size: 0.9rem;
    }

    .mobile-content-padding {
        padding-bottom: 100px; /* Space for fixed buttons */
    }

    .tags-container {
        max-height: 150px;
        overflow-y: auto;
    }

    .social-media-row {
        margin-bottom: 1rem;
    }

    .stats-mobile {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .stats-mobile .row {
        text-align: center;
    }

    .stats-mobile h4 {
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }

    .stats-mobile small {
        font-size: 0.8rem;
    }

    .current-image-mobile {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 1rem;
    }

    .card-header {
        padding: 0.75rem 1rem;
    }

    .form-label {
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }

    .form-text {
        font-size: 0.8rem;
    }

    .badge {
        font-size: 0.7rem;
    }

    .mobile-action-buttons {
        padding: 0.75rem;
    }

    .mobile-action-buttons .btn {
        padding: 0.75rem;
        font-size: 0.85rem;
    }

    .quill-editor-container .ql-toolbar .ql-formats {
        margin-right: 0.5rem;
    }

    .page-title-mobile {
        font-size: 1.25rem;
    }

    .stats-mobile .col-md-3 {
        margin-bottom: 1rem;
    }

    .stats-mobile h4 {
        font-size: 1.25rem;
    }
}

/* Responsive Quill Toolbar */
@media (max-width: 480px) {
    .quill-editor-container .ql-toolbar {
        border-bottom: 1px solid #ccc;
    }

    .quill-editor-container .ql-toolbar .ql-formats {
        margin-right: 0.25rem;
    }

    .quill-editor-container .ql-toolbar button {
        padding: 0.25rem;
        width: 28px;
        height: 28px;
    }

    .page-actions .btn {
        margin-bottom: 0.5rem;
    }
}
</style>
@endpush

@section('content')
<div class="mobile-content-padding">
    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" id="post-form">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 mobile-main-content">
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

                        <!-- FIXED EXCERPT FIELD -->
                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt <span class="text-danger">*</span></label>
                            <textarea name="excerpt" id="excerpt" class="form-control @error('excerpt') is-invalid @enderror"
                                      rows="4" maxlength="300" required
                                      placeholder="Write a brief description of your post (plain text only)...">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                            <div class="form-text">
                                <span id="excerpt-counter" class="text-muted">0/300 characters</span> - Brief description of the post (150-160 characters recommended for SEO)
                            </div>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <div class="quill-editor-container">
                                <div class="quill-editor" data-editor-id="content"></div>
                            </div>
                            <textarea name="content" id="content" style="display: none;" required>{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="featured_image" class="form-label">Featured Image</label>
                            @if($post->featured_image)
                                <div class="mb-3">
                                    <img src="{{ $post->featured_image_url }}" class="current-image-mobile img-thumbnail" style="max-width: 200px;" alt="Current featured image">
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

                <!-- Post Statistics (Mobile) -->
                <div class="card mb-4 d-lg-none">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar me-2"></i>Post Statistics
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="stats-mobile">
                            <div class="row">
                                <div class="col-6 col-md-3">
                                    <h4 class="text-primary">{{ number_format($post->views_count) }}</h4>
                                    <small class="text-muted">Views</small>
                                </div>
                                <div class="col-6 col-md-3">
                                    <h4 class="text-success">{{ $post->comments->count() }}</h4>
                                    <small class="text-muted">Total Comments</small>
                                </div>
                                <div class="col-6 col-md-3">
                                    <h4 class="text-info">{{ $post->approvedComments->count() }}</h4>
                                    <small class="text-muted">Approved Comments</small>
                                </div>
                                <div class="col-6 col-md-3">
                                    <h4 class="text-warning">{{ $post->reading_time }}</h4>
                                    <small class="text-muted">Min Read</small>
                                </div>
                            </div>
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

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="focus_keyword" class="form-label">Focus Keyword</label>
                                <input type="text" name="focus_keyword" id="focus_keyword" class="form-control @error('focus_keyword') is-invalid @enderror"
                                       value="{{ old('focus_keyword', $post->focus_keyword) }}">
                                <div class="form-text">Primary keyword you want this post to rank for</div>
                                @error('focus_keyword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="canonical_url" class="form-label">Canonical URL</label>
                                <input type="url" name="canonical_url" id="canonical_url" class="form-control @error('canonical_url') is-invalid @enderror"
                                       value="{{ old('canonical_url', $post->canonical_url) }}">
                                <div class="form-text">Leave empty to use default post URL</div>
                                @error('canonical_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
                        <div class="row social-media-row">
                            <div class="col-md-6 mb-3">
                                <label for="og_title" class="form-label">OG Title</label>
                                <input type="text" name="og_title" id="og_title" class="form-control @error('og_title') is-invalid @enderror"
                                       value="{{ old('og_title', $post->og_title) }}">
                                @error('og_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="og_image" class="form-label">OG Image URL</label>
                                <input type="url" name="og_image" id="og_image" class="form-control @error('og_image') is-invalid @enderror"
                                       value="{{ old('og_image', $post->og_image) }}">
                                @error('og_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                        <div class="row social-media-row">
                            <div class="col-md-6 mb-3">
                                <label for="twitter_title" class="form-label">Twitter Title</label>
                                <input type="text" name="twitter_title" id="twitter_title" class="form-control @error('twitter_title') is-invalid @enderror"
                                       value="{{ old('twitter_title', $post->twitter_title) }}">
                                @error('twitter_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="twitter_image" class="form-label">Twitter Image URL</label>
                                <input type="url" name="twitter_image" id="twitter_image" class="form-control @error('twitter_image') is-invalid @enderror"
                                       value="{{ old('twitter_image', $post->twitter_image) }}">
                                @error('twitter_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Publish Settings -->
                <div class="card mb-4 mobile-sidebar-card">
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
                <div class="card mb-4 mobile-sidebar-card">
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
                <div class="card mb-4 mobile-sidebar-card">
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
                <div class="card mb-4 mobile-sidebar-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tags</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Select Tags</label>
                            <div class="border rounded p-3 tags-container">
                                @foreach($tags as $tag)
                                <div class="form-check mb-2">
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

                <!-- Post Statistics (Desktop) -->
                <div class="card mb-4 d-none d-lg-block">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar me-2"></i>Post Statistics
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <h3 class="text-primary mb-1">{{ number_format($post->views_count) }}</h3>
                                <small class="text-muted">Views</small>
                            </div>
                            <div class="col-6 mb-3">
                                <h3 class="text-success mb-1">{{ $post->comments->count() }}</h3>
                                <small class="text-muted">Comments</small>
                            </div>
                            <div class="col-6">
                                <h3 class="text-info mb-1">{{ $post->approvedComments->count() }}</h3>
                                <small class="text-muted">Approved</small>
                            </div>
                            <div class="col-6">
                                <h3 class="text-warning mb-1">{{ $post->reading_time }}</h3>
                                <small class="text-muted">Min Read</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Desktop Actions -->
                <div class="card d-none d-md-block">
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
</div>

<!-- Mobile Action Buttons -->
<div class="mobile-action-buttons d-md-none">
    <div class="d-grid gap-2">
        <div class="row g-2">
            <div class="col-6">
                <button type="submit" form="post-form" name="action" value="save" class="btn btn-primary w-100">
                    <i class="fas fa-save me-1"></i>Update
                </button>
            </div>
            <div class="col-6">
                <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-outline-info w-100">
                    <i class="fas fa-eye me-1"></i>View
                </a>
            </div>
        </div>
        <button type="submit" form="post-form" name="action" value="save_and_continue" class="btn btn-outline-primary w-100">
            <i class="fas fa-edit me-1"></i>Save & Continue Editing
        </button>
    </div>
</div>
@endsection

@push('scripts')
<!-- Include Quill.js JavaScript -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
// Initialize Quill editor for content (NOT for excerpt)
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill editor for content only
    const quillContainers = document.querySelectorAll('.quill-editor');

    quillContainers.forEach(function(container) {
        const editorId = container.getAttribute('data-editor-id');
        const textarea = document.getElementById(editorId);

        if (textarea && editorId === 'content') { // Only for content, not excerpt
            const quill = new Quill(container, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        ['link', 'image', 'video'],
                        ['clean']
                    ]
                }
            });

            // Sync Quill content with textarea
            quill.on('text-change', function() {
                textarea.value = quill.root.innerHTML;
            });

            // Set initial content from existing post
            if (textarea.value) {
                quill.root.innerHTML = textarea.value;
            }
        }
    });

    // Initialize excerpt character counter
    const excerptField = document.getElementById('excerpt');
    if (excerptField) {
        updateExcerptCharacterCount(excerptField);
        excerptField.addEventListener('input', function() {
            updateExcerptCharacterCount(this);
        });
    }

    // Initialize other character counters
    updateCharacterCount(document.getElementById('meta_title'), 60);
    updateCharacterCount(document.getElementById('meta_description'), 160);
});

// Function to update excerpt character count
function updateExcerptCharacterCount(textarea) {
    const maxLength = 300;
    const current = textarea.value.length;
    const remaining = maxLength - current;

    // Color coding based on character count
    const color = remaining <= 0 ? 'text-danger' : (remaining < 50 ? 'text-warning' : 'text-muted');

    const counter = document.getElementById('excerpt-counter');
    if (counter) {
        counter.className = `form-text ${color}`;
        counter.textContent = `${current}/${maxLength} characters`;
    }
}

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

// Character counters for meta fields
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

// Handle mobile form submission
document.addEventListener('DOMContentLoaded', function() {
    const mobileButtons = document.querySelectorAll('.mobile-action-buttons button[type="submit"]');
    mobileButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('post-form');
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = this.getAttribute('name') === 'action' ? this.value : 'save';
            form.appendChild(actionInput);
            form.submit();
        });
    });
});
</script>
@endpush
