<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;

class PageController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function aboutus()
    {
        return view('pages.aboutus');
    }

    public function contactus()
    {
        return view('pages.contactus');
    }

    // public function blogs()
    // {
    //     return view('pages.blogs');
    // }

    public function projects()
    {
        return view('pages.projects');
    }

    public function services()
    {
        return view('pages.services');
    }

    public function clients()
    {
        return view('pages.clients');
    }

    public function team()
    {
        return view('pages.team');
    }

    public function testimonials()
    {
        return view('pages.testimonials');
    }

    /**
 * Generate dynamic sitemap.xml
 */
public function sitemap()
{
    
    // Static pages with their priorities and change frequencies
    $staticPages = [
        [
            'url' => route('index'),
            'lastmod' => now(),
            'changefreq' => 'weekly',
            'priority' => '1.0'
        ],
        [
            'url' => route('aboutus'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ],
        [
            'url' => route('services'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.9'
        ],
        [
            'url' => route('blogs'),
            'lastmod' => now(),
            'changefreq' => 'daily',
            'priority' => '0.9'
        ],
        [
            'url' => route('projects'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ],
        [
            'url' => route('team'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.7'
        ],
        [
            'url' => route('clients'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.7'
        ],
        [
            'url' => route('testimonials'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.7'
        ],
        [
            'url' => route('contactus'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.6'
        ]
    ];

    // Service pages
    $servicePages = [
        [
            'url' => route('services.automation'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ],
        [
            'url' => route('services.itservice'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ],
        [
            'url' => route('services.itsolutions'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ],
        [
            'url' => route('services.softwaredevelopment'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ],
        [
            'url' => route('services.staffing'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ],
        [
            'url' => route('services.training'),
            'lastmod' => now(),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ]
    ];

    // Get all published blog posts
    $blogPosts = \App\Models\Post::where('status', 'published')
        ->where('published_at', '<=', now())
        ->orderBy('published_at', 'desc')
        ->get()
        ->map(function($post) {
            return [
                'url' => route('blog.show', $post->slug),
                'lastmod' => $post->updated_at,
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ];
        });

    // Get all active blog categories
    $categories = \App\Models\PostCategory::where('status', 'active')
        ->withCount(['posts' => function($query) {
            $query->where('status', 'published');
        }])
        ->having('posts_count', '>', 0)
        ->get()
        ->map(function($category) {
            return [
                'url' => route('blogs.category', $category->slug),
                'lastmod' => $category->updated_at,
                'changefreq' => 'weekly',
                'priority' => '0.6'
            ];
        });

    // Get all active blog tags
    $tags = \App\Models\PostTag::where('status', 'active')
        ->withCount('publishedPosts')
        ->having('published_posts_count', '>', 0)
        ->get()
        ->map(function($tag) {
            return [
                'url' => route('blogs.tag', $tag->slug),
                'lastmod' => $tag->updated_at,
                'changefreq' => 'weekly',
                'priority' => '0.5'
            ];
        });

    // Combine all URLs
    $urls = collect($staticPages)
        ->merge($servicePages)
        ->merge($blogPosts)
        ->merge($categories)
        ->merge($tags);

    return response()->view('sitemap', compact('urls'))
        ->header('Content-Type', 'application/xml');
}
}
