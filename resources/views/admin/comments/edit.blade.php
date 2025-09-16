
@extends('admin.layout.app')

@section('title', 'Edit Comment')
@section('page-title', 'Edit Comment')

@section('page-actions')
<div class="d-flex gap-2">
    <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Comments
    </a>
    <a href="{{ route('admin.comments.show', $comment) }}" class="btn btn-outline-info">
        <i class="fas fa-eye me-2"></i>View Comment
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Comment Form -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Comment Details</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.comments.update', $comment) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $comment->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $comment->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="url" name="website" id="website"
                               class="form-control @error('website') is-invalid @enderror"
                               value="{{ old('website', $comment->website) }}"
                               placeholder="https://example.com">
                        @error('website')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Comment <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" rows="6"
                                  class="form-control @error('content') is-invalid @enderror"
                                  required>{{ old('content', $comment->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="pending" {{ old('status', $comment->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ old('status', $comment->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ old('status', $comment->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="spam" {{ old('status', $comment->status) === 'spam' ? 'selected' : '' }}>Spam</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check form-switch mt-4">
                                    <input type="hidden" name="is_featured" value="0">
                                    <input class="form-check-input" type="checkbox" name="is_featured"
                                           id="is_featured" value="1"
                                           {{ old('is_featured', $comment->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Featured Comment
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Comment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Comment Information -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Comment Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">Post</label>
                    <div>
                        <a href="{{ route('admin.posts.show', $comment->post) }}" class="text-decoration-none">
                            {{ $comment->post->title }}
                        </a>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Submitted Date</label>
                    <div>{{ $comment->created_at->format('M d, Y h:i A') }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Last Updated</label>
                    <div>{{ $comment->updated_at->format('M d, Y h:i A') }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">IP Address</label>
                    <div>{{ $comment->ip_address ?? 'Not recorded' }}</div>
                </div>

                @if($comment->user_agent)
                <div class="mb-3">
                    <label class="form-label text-muted">User Agent</label>
                    <div class="small text-break">{{ Str::limit($comment->user_agent, 100) }}</div>
                </div>
                @endif

                @if($comment->parent_id)
                <div class="mb-3">
                    <label class="form-label text-muted">Reply To</label>
                    <div>
                        <a href="{{ route('admin.comments.show', $comment->parent) }}" class="text-decoration-none">
                            {{ $comment->parent->name }}
                        </a>
                    </div>
                </div>
                @endif

                <div class="mb-3">
                    <label class="form-label text-muted">Avatar</label>
                    <div>
                        <img src="{{ $comment->avatar }}" class="rounded-circle" width="50" height="50" alt="{{ $comment->name }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                @if($comment->status === 'pending')
                <form method="POST" action="{{ route('admin.comments.approve', $comment) }}" class="d-inline-block w-100 mb-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-check me-2"></i>Approve Comment
                    </button>
                </form>
                @endif

                @if($comment->status !== 'rejected')
                <form method="POST" action="{{ route('admin.comments.reject', $comment) }}" class="d-inline-block w-100 mb-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="fas fa-times me-2"></i>Reject Comment
                    </button>
                </form>
                @endif

                <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}"
                      class="d-inline-block w-100"
                      onsubmit="return confirm('Are you sure you want to delete this comment? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash me-2"></i>Delete Comment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
