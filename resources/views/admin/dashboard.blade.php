@extends('admin.layout.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-3 mb-4">
        <div class="card card-stats text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0 text-white-50">Total Posts</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $stats['total_posts'] }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-white text-primary rounded-circle shadow">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-white-50 text-sm">
                    <span class="text-white mr-2">{{ $stats['published_posts'] }}</span>
                    Published
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card card-stats-2 text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0 text-white-50">Comments</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $stats['total_comments'] }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-white text-primary rounded-circle shadow">
                            <i class="fas fa-comments fa-2x"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-white-50 text-sm">
                    <span class="text-white mr-2">{{ $stats['pending_comments'] }}</span>
                    Pending approval
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card card-stats-3 text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0 text-white-50">Categories</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $stats['total_categories'] }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-white text-primary rounded-circle shadow">
                            <i class="fas fa-folder fa-2x"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-white-50 text-sm">
                    <span class="text-white mr-2">{{ $stats['total_tags'] }}</span>
                    Tags available
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card card-stats-4 text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0 text-white-50">Staff</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $stats['total_staff'] }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-white text-primary rounded-circle shadow">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-white-50 text-sm">
                    <span class="text-white mr-2">{{ $stats['active_staff'] }}</span>
                    Active members
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Posts -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Posts</h5>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentPosts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPosts as $post)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.posts.show', $post) }}" class="text-decoration-none">
                                            {{ Str::limit($post->title, 40) }}
                                        </a>
                                        @if($post->is_featured)
                                            <span class="badge bg-warning text-dark ms-1">Featured</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->staff->name }}</td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $post->category->color }}">
                                            {{ $post->category->name }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($post->status === 'published')
                                            <span class="badge bg-success">Published</span>
                                        @elseif($post->status === 'draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @else
                                            <span class="badge bg-warning text-dark">{{ ucfirst($post->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No posts yet. <a href="{{ route('admin.posts.create') }}">Create your first post</a></p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Stats & Actions -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create New Post
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-folder-plus me-2"></i>Add Category
                    </a>
                    <a href="{{ route('admin.staff.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user-plus me-2"></i>Add Staff Member
                    </a>
                </div>

                <hr>

                <h6>Content Overview</h6>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-primary">{{ $stats['draft_posts'] }}</h4>
                            <small class="text-muted">Draft Posts</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">{{ $stats['approved_comments'] }}</h4>
                        <small class="text-muted">Approved Comments</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Comments -->
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Comments</h5>
                <a href="{{ route('admin.comments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentComments->count() > 0)
                    @foreach($recentComments as $comment)
                    <div class="d-flex mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                        <img src="{{ $comment->avatar }}" class="rounded-circle me-3" width="40" height="40" alt="{{ $comment->name }}">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fs-6">{{ $comment->name }}</h6>
                            <p class="mb-1 small text-muted">{{ Str::limit($comment->content, 60) }}</p>
                            <small class="text-muted">
                                on <a href="{{ route('admin.posts.show', $comment->post) }}" class="text-decoration-none">{{ Str::limit($comment->post->title, 30) }}</a>
                            </small>
                            <div class="mt-1">
                                @if($comment->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($comment->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($comment->status === 'spam')
                                    <span class="badge bg-danger">Spam</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($comment->status) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-comments fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No comments yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Popular Posts -->
@if($popularPosts->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Popular Posts (by Views)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Views</th>
                                <th>Comments</th>
                                <th>Published</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($popularPosts as $post)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.posts.show', $post) }}" class="text-decoration-none">
                                        {{ $post->title }}
                                    </a>
                                    @if($post->is_featured)
                                        <span class="badge bg-warning text-dark ms-1">Featured</span>
                                    @endif
                                </td>
                                <td>{{ $post->staff->name }}</td>
                                <td>
                                    <span class="badge" style="background-color: {{ $post->category->color }}">
                                        {{ $post->category->name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($post->views_count) }}</span>
                                </td>
                                <td>{{ $post->approvedComments->count() }}</td>
                                <td>{{ $post->published_at ? $post->published_at->format('M d, Y') : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
