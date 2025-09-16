<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\PostComment;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['staff', 'category', 'approvedComments'])
            ->where('status', 'published')
            ->orderBy('published_at', 'desc');

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category)
                  ->where('status', 'active');
            });
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('excerpt', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%');
            });
        }

        // Check if this is an AJAX request for loading more posts
        if ($request->ajax() && $request->has('load_more')) {
            // Get all posts for AJAX request
            $allBlogs = $query->get();

            return response()->json([
                'success' => true,
                'blogs' => $allBlogs->map(function($blog) {
                    return [
                        'title' => $blog->title,
                        'slug' => $blog->slug,
                        'excerpt' => Str::limit($blog->excerpt, 120),
                        'featured_image_url' => $blog->featured_image_url,
                        'category_name' => $blog->category->name,
                        'staff_name' => $blog->staff->name,
                        'staff_avatar_url' => $blog->staff->avatar_url,
                        'published_date' => $blog->published_date,
                        'views_count' => $blog->views_count ?? 0,
                        'comments_count' => $blog->approvedComments->count(),
                        'reading_time' => $blog->reading_time ?? 5,
                        'is_featured' => $blog->is_featured,
                        'blog_show_url' => route('blog.show', $blog->slug)
                    ];
                })
            ]);
        }

        // For normal page load, get total count first
        $totalPosts = $query->count();

        // Then get only first 3 posts
        $blogs = $query->take(3)->get();

        // Get all active categories for filter dropdown
        $categories = PostCategory::where('status', 'active')
            ->withCount(['posts' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('name')
            ->get();

        // Get featured posts
        $featuredPosts = Post::with(['staff', 'category'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('pages.blogs', compact('blogs', 'categories', 'featuredPosts', 'totalPosts'));
    }

    public function show($slug)
    {
        // Find the blog post by slug
        $blog = Post::with(['staff', 'category', 'tags', 'comments' => function($query) {
                $query->where('status', 'approved')
                      ->orderBy('created_at', 'desc');
            }])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment view count
        $blog->increment('views_count');

        // Get related blogs from the same category
        $relatedBlogs = Post::with(['staff', 'category'])
            ->where('status', 'published')
            ->where('post_category_id', $blog->post_category_id)
            ->where('id', '!=', $blog->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // If no related blogs in same category, get recent posts
        if ($relatedBlogs->count() < 3) {
            $additionalBlogs = Post::with(['staff', 'category'])
                ->where('status', 'published')
                ->where('id', '!=', $blog->id)
                ->whereNotIn('id', $relatedBlogs->pluck('id'))
                ->orderBy('published_at', 'desc')
                ->take(3 - $relatedBlogs->count())
                ->get();

            $relatedBlogs = $relatedBlogs->merge($additionalBlogs);
        }

        // Get next and previous posts
        $nextPost = Post::where('status', 'published')
            ->where('published_at', '>', $blog->published_at)
            ->orderBy('published_at', 'asc')
            ->first();

        $previousPost = Post::where('status', 'published')
            ->where('published_at', '<', $blog->published_at)
            ->orderBy('published_at', 'desc')
            ->first();

        return view('pages.blog-single', compact(
            'blog',
            'relatedBlogs',
            'nextPost',
            'previousPost'
        ));
    }

    public function category($categorySlug)
    {
        // Find the category
        $category = PostCategory::where('slug', $categorySlug)
            ->where('status', 'active')
            ->firstOrFail();

        // Get posts in this category
        $blogs = Post::with(['staff', 'category', 'comments'])
            ->where('status', 'published')
            ->where('post_category_id', $category->id)
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        // Get all active categories for filter dropdown
        $categories = PostCategory::where('status', 'active')
            ->withCount(['posts' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('name')
            ->get();

        return view('pages.blogs', compact('blogs', 'categories', 'category'));
    }

    public function tag($tagSlug)
    {
        // Find the tag
        $tag = PostTag::where('slug', $tagSlug)
            ->where('status', 'active')
            ->firstOrFail();

        // Get posts with this tag
        $blogs = Post::with(['staff', 'category', 'comments'])
            ->where('status', 'published')
            ->whereHas('tags', function($query) use ($tag) {
                $query->where('post_tag_id', $tag->id);
            })
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        // Get all active categories for filter dropdown
        $categories = PostCategory::where('status', 'active')
            ->withCount(['posts' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('name')
            ->get();

        return view('pages.blogs', compact('blogs', 'categories', 'tag'));
    }

    public function archive($year, $month = null)
    {
        $query = Post::with(['staff', 'category', 'comments'])
            ->where('status', 'published')
            ->whereYear('published_at', $year);

        if ($month) {
            $query->whereMonth('published_at', $month);
        }

        $blogs = $query->orderBy('published_at', 'desc')->paginate(9);

        // Get all active categories for filter dropdown
        $categories = PostCategory::where('status', 'active')
            ->withCount(['posts' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('name')
            ->get();

        $archiveDate = [
            'year' => $year,
            'month' => $month,
            'month_name' => $month ? date('F', mktime(0, 0, 0, $month, 1)) : null
        ];

        return view('pages.blogs', compact('blogs', 'categories', 'archiveDate'));
    }

    public function storeComment(Request $request)
{
    // Validate the comment data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'website' => 'nullable|url|max:255',
        'content' => 'required|string|max:1000',
        'post_id' => 'required|exists:posts,id',
    ]);

    // Find the blog post
    $post = Post::where('id', $validated['post_id'])
                ->where('status', 'published')
                ->firstOrFail();

    // Check if comments are allowed for this post
    if (!$post->allow_comments) {
        return redirect()->back()->withErrors(['error' => 'Comments are not allowed for this post.']);
    }

    // Store the comment using PostComment model
    \App\Models\PostComment::create([
        'post_id' => $post->id,
        'name' => $validated['name'],
        'email' => $validated['email'],
        'website' => $validated['website'],
        'content' => $validated['content'],
        'status' => 'pending', // Comments need admin approval
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);

    // Redirect back with success message
    return redirect()->back()->with('success', 'Comments have been submitted and appear on the post after admin approval');
}
}
