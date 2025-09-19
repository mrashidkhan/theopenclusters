<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') | {{ config('app.name') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Quill.js CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- Custom Admin CSS -->
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            width: 250px;
            background-color: #212529;
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1rem;
            border-radius: 0;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: #495057;
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
        }

        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 16px;
        }

        /* Sidebar heading visibility fix */
        .sidebar .sidebar-heading {
            color: #16C60C !important;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .main-content {
            margin-left: 250px;
            padding-top: 48px;
        }

        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
        }

        .navbar-nav .nav-link {
            padding-right: .5rem;
            padding-left: .5rem;
        }

        .card-stats {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }

        .card-stats-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
        }

        .card-stats-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            color: white;
        }

        .card-stats-4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            border: none;
            color: white;
        }

        .table-actions {
            white-space: nowrap;
        }

        .table-actions .btn {
            padding: 0.25rem 0.5rem;
            margin: 0 0.125rem;
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.25em 0.5em;
        }

        .featured-badge {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            color: #333;
            font-weight: bold;
        }

        /* Custom Quill.js Styles */
        .quill-editor-container {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            background: white;
        }

        .quill-editor-container .ql-toolbar {
            border: none;
            border-bottom: 1px solid #ced4da;
            border-radius: 0.375rem 0.375rem 0 0;
        }

        .quill-editor-container .ql-container {
            border: none;
            border-radius: 0 0 0.375rem 0.375rem;
            font-size: 14px;
        }

        .quill-editor-container .ql-editor {
            min-height: 300px;
            max-height: 500px;
            overflow-y: auto;
        }

        .quill-editor-container .ql-editor.ql-blank::before {
            color: #6c757d;
            font-style: italic;
        }

        /* Fixed User Dropdown Styles */
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.3);
            flex-shrink: 0;
        }

        .navbar-nav .dropdown {
            position: static;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s ease;
            white-space: nowrap;
            max-width: 250px;
        }

        .user-info:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .user-info:focus {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.2);
        }

        .dropdown-menu {
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            left: auto !important;
            z-index: 1050 !important;
            display: none;
            min-width: 280px;
            max-width: 320px;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
            margin-top: 0.5rem;
            transform: none !important;
        }

        .dropdown-menu.show {
            display: block !important;
        }

        .dropdown-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e9ecef;
            background-color: #f8f9fa;
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            color: #212529;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background-color: #f8f9fa;
            color: #212529;
        }

        .dropdown-item.text-danger:hover {
            background-color: #f8d7da;
            color: #842029;
        }

        .dropdown-divider {
            margin: 0.25rem 0;
            border-top: 1px solid #e9ecef;
        }

        .user-status-badge {
            font-size: 0.7rem;
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
            flex-shrink: 0;
        }

        /* Ensure navbar doesn't stretch */
        .navbar {
            min-height: 48px;
            max-height: 48px;
        }

        .navbar-nav {
            flex-direction: row;
        }

        .nav-item {
            position: relative;
        }

        /* Mobile responsive fixes */
        @media (max-width: 768px) {
            .user-info span {
                display: none !important;
            }

            .dropdown-menu {
                min-width: 250px;
                right: 1rem !important;
            }
        }

        /* Prevent layout shift */
        .dropdown-toggle::after {
            margin-left: 0.5rem;
            vertical-align: middle;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Top Navigation -->
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-cogs me-2"></i>Admin Panel
        </a>

        <div class="navbar-nav ms-auto pe-3">
            @auth('admin')
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle user-info" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::guard('admin')->user()->avatar_url }}" alt="{{ Auth::guard('admin')->user()->name }}" class="user-avatar">
                        <span class="d-none d-md-inline">{{ Auth::guard('admin')->user()->name }}</span>
                        <span class="badge user-status-badge {{ Auth::guard('admin')->user()->status_badge_class }} d-none d-lg-inline">
                            {{ Auth::guard('admin')->user()->role_display_name }}
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="dropdown-header">
                                <div class="fw-bold">{{ Auth::guard('admin')->user()->name }}</div>
                                <small class="text-muted">{{ Auth::guard('admin')->user()->email }}</small>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                <i class="fas fa-user-circle text-primary"></i>
                                My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt text-info"></i>
                                Dashboard
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('index') }}" target="_blank">
                                <i class="fas fa-external-link-alt text-success"></i>
                                View Website
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('admin.logout') }}" class="d-inline w-100">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to logout?')">
                                    <i class="fas fa-sign-out-alt text-danger"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <div class="nav-item">
                    <a class="nav-link" href="{{ route('admin.login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                </div>
            @endauth
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="sidebar d-md-block bg-dark">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1">
                        <span>Content Management</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.posts*') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">
                                <i class="fas fa-file-alt"></i>
                                Posts
                                @php
                                    $draftCount = \App\Models\Post::where('status', 'draft')->count();
                                @endphp
                                @if($draftCount > 0)
                                    <span class="badge bg-warning text-dark ms-auto">{{ $draftCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                                <i class="fas fa-folder"></i>
                                Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.tags*') ? 'active' : '' }}" href="{{ route('admin.tags.index') }}">
                                <i class="fas fa-tags"></i>
                                Tags
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1">
                        <span>Engagement</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.comments*') ? 'active' : '' }}" href="{{ route('admin.comments.index') }}">
                                <i class="fas fa-comments"></i>
                                Comments
                                @php
                                    $pendingCount = \App\Models\PostComment::where('status', 'pending')->count();
                                @endphp
                                @if($pendingCount > 0)
                                    <span class="badge bg-danger ms-auto">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.comments.pending') ? 'active' : '' }}" href="{{ route('admin.comments.pending') }}">
                                <i class="fas fa-clock"></i>
                                Pending Comments
                                @if($pendingCount > 0)
                                    <span class="badge bg-warning text-dark ms-auto">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1">
                        <span>Team Management</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.staff*') ? 'active' : '' }}" href="{{ route('admin.staff.index') }}">
                                <i class="fas fa-users"></i>
                                Staff
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1">
                        <span>Quick Actions</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.posts.create') }}">
                                <i class="fas fa-plus"></i>
                                New Post
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.categories.create') }}">
                                <i class="fas fa-plus"></i>
                                New Category
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.staff.create') }}">
                                <i class="fas fa-plus"></i>
                                New Staff
                            </a>
                        </li>
                    </ul>

                    <!-- User Info in Sidebar (for mobile) -->
                    @auth('admin')
                    <div class="d-md-none mt-4 px-3">
                        <hr class="text-muted">
                        <div class="text-center">
                            <img src="{{ Auth::guard('admin')->user()->avatar_url }}" alt="{{ Auth::guard('admin')->user()->name }}" class="user-avatar mb-2">
                            <div class="text-white-50 small">{{ Auth::guard('admin')->user()->name }}</div>
                            <div class="text-white-50 small">{{ Auth::guard('admin')->user()->role_display_name }}</div>
                            <form method="POST" action="{{ route('admin.logout') }}" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm" onclick="return confirm('Are you sure you want to logout?')">
                                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>
            </nav>

            <!-- Main Content -->
            <main class="main-content">
                <div class="container-fluid">
                    <!-- Page Header -->
                    @if(isset($pageTitle) || View::hasSection('page-title'))
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">@yield('page-title', $pageTitle ?? '')</h1>
                        @yield('page-actions')
                    </div>
                    @endif

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Main Content Area -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js for dashboard -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Quill.js JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    if (alert.querySelector('.btn-close')) {
                        alert.querySelector('.btn-close').click();
                    }
                });
            }, 5000);

            // Initialize Quill editors
            initializeQuillEditors();
        });

        // Initialize Quill.js editors
        function initializeQuillEditors() {
            const quillContainers = document.querySelectorAll('.quill-editor');

            quillContainers.forEach(function(container) {
                const editorId = container.getAttribute('data-editor-id');
                const textarea = document.getElementById(editorId);

                if (textarea && !container.querySelector('.ql-toolbar')) {
                    const quill = new Quill(container, {
                        theme: 'snow',
                        placeholder: 'Write your content here...',
                        modules: {
                            toolbar: [
                                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                                [{ 'font': [] }],
                                [{ 'size': ['small', false, 'large', 'huge'] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{ 'color': [] }, { 'background': [] }],
                                [{ 'script': 'sub'}, { 'script': 'super' }],
                                [{ 'align': [] }],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                [{ 'indent': '-1'}, { 'indent': '+1' }],
                                ['blockquote', 'code-block'],
                                ['link', 'image', 'video'],
                                ['clean']
                            ]
                        }
                    });

                    // Set initial content from textarea
                    if (textarea.value) {
                        quill.root.innerHTML = textarea.value;
                    }

                    // Sync content with hidden textarea on change
                    quill.on('text-change', function() {
                        textarea.value = quill.root.innerHTML;
                    });

                    // Also sync on form submission
                    const form = textarea.closest('form');
                    if (form) {
                        form.addEventListener('submit', function() {
                            textarea.value = quill.root.innerHTML;
                        });
                    }
                }
            });
        }

        // Function to reinitialize Quill editors (useful for dynamic content)
        function reinitializeQuillEditors() {
            initializeQuillEditors();
        }

        // Confirm delete actions
        function confirmDelete(message = 'Are you sure you want to delete this item?') {
            return confirm(message);
        }

        // Select All checkbox functionality
        function toggleSelectAll(selectAllCheckbox) {
            const checkboxes = document.querySelectorAll('input[name="items[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            updateBulkActions();
        }

        // Update bulk actions visibility
        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('input[name="items[]"]:checked');
            const bulkActions = document.querySelector('.bulk-actions');
            if (bulkActions) {
                bulkActions.style.display = checkboxes.length > 0 ? 'block' : 'none';
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
