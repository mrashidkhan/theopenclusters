@extends('admin.layout.app')

@section('title', 'Staff Management')
@section('page-title', 'Staff Management')

@section('page-actions')
<a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Add New Staff Member
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if($staff->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Position</th>
                            <th>Contact</th>
                            <th>Posts</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staff as $member)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $member->avatar_url }}" class="rounded-circle me-3" width="50" height="50" alt="">
                                    <div>
                                        <a href="{{ route('admin.staff.show', $member) }}" class="text-decoration-none fw-medium">
                                            {{ $member->name }}
                                        </a>
                                        @if($member->bio)
                                            <div class="small text-muted">{{ Str::limit($member->bio, 60) }}</div>
                                        @endif
                                        <div class="small">
                                            <code>{{ $member->slug }}</code>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($member->position)
                                    <span class="badge bg-light text-dark">{{ $member->position }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <div><i class="fas fa-envelope me-1"></i>{{ $member->email }}</div>
                                    @if($member->phone)
                                        <div><i class="fas fa-phone me-1"></i>{{ $member->phone }}</div>
                                    @endif
                                    @if($member->social_links)
                                        <div class="mt-1">
                                            @foreach($member->social_links as $platform => $url)
                                                @if($url)
                                                    <a href="{{ $url }}" target="_blank" class="text-muted me-2" title="{{ ucfirst($platform) }}">
                                                        <i class="fab fa-{{ $platform }}"></i>
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-center">
                                    <span class="fw-bold">{{ $member->posts_count }}</span>
                                    @if($member->posts_count > 0)
                                        <div>
                                            <a href="{{ route('admin.posts.index', ['author' => $member->id]) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($member->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                {{ $member->created_at->format('M d, Y') }}
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.staff.show', $member) }}" class="btn btn-sm btn-outline-info" title="View Profile">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.staff.edit', $member) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form method="POST" action="{{ route('admin.staff.toggle-status', $member) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="{{ $member->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-{{ $member->status === 'active' ? 'toggle-on' : 'toggle-off' }}"></i>
                                        </button>
                                    </form>

                                    @if($member->posts_count === 0)
                                    <form method="POST" action="{{ route('admin.staff.destroy', $member) }}" class="d-inline" onsubmit="return confirmDelete('Are you sure you want to delete this staff member?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @else
                                    <button class="btn btn-sm btn-outline-danger" disabled title="Cannot delete staff member with posts">
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
                    Showing {{ $staff->firstItem() }} to {{ $staff->lastItem() }} of {{ $staff->total() }} staff members
                </div>
                {{ $staff->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">No staff members found</h5>
                <p class="text-muted">Get started by <a href="{{ route('admin.staff.create') }}">adding your first staff member</a>.</p>
            </div>
        @endif
    </div>
</div>

<!-- Staff Statistics -->
@if($staff->count() > 0)
<div class="card mt-4">
    <div class="card-header">
        <h6 class="card-title mb-0">Staff Statistics</h6>
    </div>
    <div class="card-body">
        <div class="row text-center">
            @php
                $totalStaff = $staff->total();
                $activeStaff = \App\Models\Staff::where('status', 'active')->count();
                $staffWithPosts = \App\Models\Staff::has('posts')->count();
                $totalPosts = \App\Models\Post::count();
            @endphp
            <div class="col-md-3">
                <h4 class="text-primary">{{ $totalStaff }}</h4>
                <small class="text-muted">Total Staff</small>
            </div>
            <div class="col-md-3">
                <h4 class="text-success">{{ $activeStaff }}</h4>
                <small class="text-muted">Active Members</small>
            </div>
            <div class="col-md-3">
                <h4 class="text-info">{{ $staffWithPosts }}</h4>
                <small class="text-muted">Authors</small>
            </div>
            <div class="col-md-3">
                <h4 class="text-warning">{{ $totalPosts }}</h4>
                <small class="text-muted">Total Posts</small>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Tips -->
<div class="card mt-4">
    <div class="card-body">
        <h6><i class="fas fa-info-circle me-2"></i>Tips:</h6>
        <ul class="mb-0 small text-muted">
            <li>Staff members can be assigned as authors for blog posts</li>
            <li>Upload avatars for better profile presentation</li>
            <li>Add social media links to showcase team members</li>
            <li>Staff with posts cannot be deleted - reassign posts first</li>
            <li>Use descriptive positions to help visitors understand roles</li>
        </ul>
    </div>
</div>
@endsection
