<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\PostComment;
use App\Models\Staff;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'total_categories' => PostCategory::count(),
            'total_tags' => PostTag::count(),
            'total_comments' => PostComment::count(),
            'pending_comments' => PostComment::where('status', 'pending')->count(),
            'approved_comments' => PostComment::where('status', 'approved')->count(),
            'total_staff' => Staff::count(),
            'active_staff' => Staff::where('status', 'active')->count(),
        ];

        // Recent posts
        $recentPosts = Post::with(['staff', 'category'])
                          ->orderBy('created_at', 'desc')
                          ->limit(5)
                          ->get();

        // Recent comments
        $recentComments = PostComment::with('post')
                                   ->orderBy('created_at', 'desc')
                                   ->limit(5)
                                   ->get();

        // Popular posts (by views)
        $popularPosts = Post::published()
                           ->orderBy('views_count', 'desc')
                           ->limit(5)
                           ->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentComments', 'popularPosts'));
    }
}
