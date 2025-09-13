<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Sample blog data - you can later move this to a database
    private function getBlogData()
    {
        return [
            [
                'id' => 1,
                'slug' => 'modern-web-design-trends-2024',
                'title' => 'Modern Web Design Trends for 2024',
                'category' => 'Web Design',
                'author' => 'Daniel Martin',
                'date' => '24 March 2023',
                'image' => 'blog-1.jpg',
                'excerpt' => 'Discover the latest web design trends that are shaping the digital landscape in 2024. From minimalist layouts to interactive elements.',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                'shares' => 5324,
                'comments' => 5
            ],
            [
                'id' => 2,
                'slug' => 'php-laravel-development-best-practices',
                'title' => 'PHP Laravel Development Best Practices',
                'category' => 'Development',
                'author' => 'Sarah Johnson',
                'date' => '23 April 2023',
                'image' => 'blog-2.jpg',
                'excerpt' => 'Learn essential Laravel development practices that will make your code more maintainable, secure, and efficient.',
                'content' => 'Laravel has become one of the most popular PHP frameworks for web development. In this comprehensive guide, we will explore the best practices that every Laravel developer should follow to build robust and scalable applications.',
                'shares' => 4521,
                'comments' => 8
            ],
            [
                'id' => 3,
                'slug' => 'mobile-app-development-guide',
                'title' => 'Complete Guide to Mobile App Development',
                'category' => 'Mobile App',
                'author' => 'Michael Chen',
                'date' => '30 Jan 2023',
                'image' => 'blog-3.jpg',
                'excerpt' => 'Everything you need to know about mobile app development, from planning to deployment across different platforms.',
                'content' => 'Mobile app development has evolved significantly over the years. Whether you are planning to build a native app or a cross-platform solution, this guide will walk you through the entire process step by step.',
                'shares' => 6789,
                'comments' => 12
            ],
            [
                'id' => 4,
                'slug' => 'cloud-computing-solutions-2024',
                'title' => 'Cloud Computing Solutions for Modern Businesses',
                'category' => 'Cloud Technology',
                'author' => 'Emily Davis',
                'date' => '15 May 2023',
                'image' => 'blog-1.jpg',
                'excerpt' => 'Explore how cloud computing is transforming business operations and discover the best cloud solutions for your organization.',
                'content' => 'Cloud computing has revolutionized the way businesses operate, offering scalability, flexibility, and cost-effectiveness. In this article, we delve into various cloud solutions and their benefits for modern enterprises.',
                'shares' => 3456,
                'comments' => 7
            ],
            [
                'id' => 5,
                'slug' => 'cybersecurity-best-practices',
                'title' => 'Essential Cybersecurity Best Practices',
                'category' => 'Security',
                'author' => 'Robert Wilson',
                'date' => '10 June 2023',
                'image' => 'blog-2.jpg',
                'excerpt' => 'Protect your business from cyber threats with these essential cybersecurity practices and security measures.',
                'content' => 'With the increasing number of cyber threats, implementing robust cybersecurity measures has become crucial for businesses of all sizes. This article covers essential practices to safeguard your digital assets.',
                'shares' => 2987,
                'comments' => 4
            ],
            [
                'id' => 6,
                'slug' => 'artificial-intelligence-business-applications',
                'title' => 'AI Applications in Modern Business',
                'category' => 'Artificial Intelligence',
                'author' => 'Lisa Thompson',
                'date' => '22 July 2023',
                'image' => 'blog-3.jpg',
                'excerpt' => 'Discover how artificial intelligence is being applied across various business sectors to improve efficiency and innovation.',
                'content' => 'Artificial Intelligence is no longer a futuristic concept but a present reality transforming industries. From customer service chatbots to predictive analytics, AI is reshaping how businesses operate and serve their customers.',
                'shares' => 8765,
                'comments' => 15
            ]
        ];
    }

    public function index()
    {
        $blogs = $this->getBlogData();
        return view('pages.blogs', compact('blogs'));
    }

    public function show($slug)
    {
        $blogs = $this->getBlogData();
        $blog = collect($blogs)->firstWhere('slug', $slug);

        if (!$blog) {
            abort(404);
        }

        // Get related blogs (excluding current blog)
        $relatedBlogs = collect($blogs)
            ->where('slug', '!=', $slug)
            ->take(3)
            ->toArray();

        return view('pages.blog-single', compact('blog', 'relatedBlogs'));
    }
}
