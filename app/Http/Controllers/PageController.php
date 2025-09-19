<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Traits\MetaTags;

class PageController extends Controller
{
    use MetaTags;

    public function index()
    {
        $this->setMetaTags([
            'title' => 'Open Clusters Systems - IT Solutions & Software Development',
            'description' => 'Leading IT solutions provider offering software development, automation, digital marketing, and business consulting services. Transform your business with cutting-edge technology.',
            'keywords' => 'IT Solutions, Software Development, Automation, Digital Marketing, Business Consulting, Technology Services',
            'image' => asset('img/logo.png'),
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => 'Open Clusters Systems',
                'url' => route('index'),
                'logo' => asset('img/logo.png'),
                'description' => 'Leading IT solutions provider offering comprehensive technology services',
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => '+1-760-412-0990',
                    'contactType' => 'customer service'
                ]
            ]
        ]);

        return view('pages.index');
    }

    public function aboutus()
    {
        $this->setMetaTags([
            'title' => 'About Us - Open Clusters Systems | Expert IT Team',
            'description' => 'Learn about Open Clusters Systems, our expert team, mission, and commitment to delivering innovative IT solutions that drive business success.',
            'keywords' => 'About Open Clusters, IT Company, Expert Team, Mission, Vision, Technology Leadership',
            'canonical' => route('aboutus')
        ]);

        return view('pages.aboutus');
    }

    public function contactus()
    {
        $this->setMetaTags([
            'title' => 'Contact Us - Open Clusters Systems | Get in Touch',
            'description' => 'Contact Open Clusters Systems for your IT needs. Get expert consultation, project quotes, and technical support. Located in California.',
            'keywords' => 'Contact Open Clusters, IT Support, Consultation, California IT Company, Technical Support',
            'canonical' => route('contactus'),
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'ContactPage',
                'name' => 'Contact Open Clusters Systems',
                'description' => 'Get in touch with our IT experts',
                'url' => route('contactus')
            ]
        ]);

        return view('pages.contactus');
    }

    public function projects()
    {
        $this->setMetaTags([
            'title' => 'Our Projects - Open Clusters Systems | Portfolio & Case Studies',
            'description' => 'Explore our successful IT projects and case studies. See how we\'ve helped businesses transform with innovative technology solutions.',
            'keywords' => 'IT Projects, Portfolio, Case Studies, Software Development Projects, Technology Solutions',
            'canonical' => route('projects')
        ]);

        return view('pages.projects');
    }

    public function services()
    {
        $this->setMetaTags([
            'title' => 'IT Services - Open Clusters Systems | Complete Technology Solutions',
            'description' => 'Comprehensive IT services including software development, automation, digital marketing, training, and staffing solutions for modern businesses.',
            'keywords' => 'IT Services, Software Development, Automation, Digital Marketing, IT Training, IT Staffing',
            'canonical' => route('services'),
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => 'IT Services',
                'provider' => [
                    '@type' => 'Organization',
                    'name' => 'Open Clusters Systems'
                ],
                'description' => 'Complete technology solutions for businesses'
            ]
        ]);

        return view('pages.services');
    }

    public function clients()
    {
        $this->setMetaTags([
            'title' => 'Our Clients - Open Clusters Systems | Trusted Partners',
            'description' => 'Meet our valued clients and partners who trust Open Clusters Systems for their IT needs. Join our growing community of successful businesses.',
            'keywords' => 'Open Clusters Clients, Business Partners, Customer Success, IT Solutions Clients',
            'canonical' => route('clients')
        ]);

        return view('pages.clients');
    }

    public function team()
    {
        $this->setMetaTags([
            'title' => 'Our Team - Open Clusters Systems | Expert IT Professionals',
            'description' => 'Meet our skilled team of IT professionals, developers, and consultants dedicated to delivering exceptional technology solutions.',
            'keywords' => 'IT Team, Expert Developers, Technology Consultants, Professional Team, IT Experts',
            'canonical' => route('team'),
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => 'Open Clusters Systems Team',
                'description' => 'Expert IT professionals and developers',
                'url' => route('team')
            ]
        ]);

        return view('pages.team');
    }

    public function testimonials()
    {
        $this->setMetaTags([
            'title' => 'Client Testimonials - Open Clusters Systems | Success Stories',
            'description' => 'Read what our clients say about working with Open Clusters Systems. Discover success stories and client experiences.',
            'keywords' => 'Client Testimonials, Success Stories, Customer Reviews, IT Services Reviews',
            'canonical' => route('testimonials')
        ]);

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
