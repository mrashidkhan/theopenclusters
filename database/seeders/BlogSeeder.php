<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\Post;
use App\Models\PostComment;
use Carbon\Carbon;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Staff/Authors
        $authors = [
            [
                'name' => 'Daniel Martin',
                'email' => 'daniel@theopenclusters.com',
                'slug' => 'daniel-martin',
                'position' => 'Senior Developer',
                'bio' => 'Experienced full-stack developer with expertise in modern web technologies.',
                'avatar' => 'avatars/daniel.jpg',
                'social_links' => [
                    'twitter' => 'https://twitter.com/danielmartin',
                    'linkedin' => 'https://linkedin.com/in/danielmartin'
                ]
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@theopenclusters.com',
                'slug' => 'sarah-johnson',
                'position' => 'Lead Designer',
                'bio' => 'Creative designer passionate about user experience and modern design trends.',
                'avatar' => 'avatars/sarah.jpg',
                'social_links' => [
                    'twitter' => 'https://twitter.com/sarahjohnson',
                    'dribbble' => 'https://dribbble.com/sarahjohnson'
                ]
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael@theopenclusters.com',
                'slug' => 'michael-chen',
                'position' => 'Mobile App Developer',
                'bio' => 'Mobile development specialist with focus on iOS and Android applications.',
                'avatar' => 'avatars/michael.jpg',
                'social_links' => [
                    'github' => 'https://github.com/michaelchen',
                    'linkedin' => 'https://linkedin.com/in/michaelchen'
                ]
            ]
        ];

        foreach ($authors as $author) {
            Staff::create($author);
        }

        // Create Categories
        $categories = [
            [
                'name' => 'Web Design',
                'slug' => 'web-design',
                'description' => 'Latest trends and techniques in web design',
                'color' => '#007bff',
                'icon' => 'fas fa-paint-brush',
                'meta_title' => 'Web Design Articles | Open Clusters',
                'meta_description' => 'Discover the latest web design trends, techniques, and best practices.'
            ],
            [
                'name' => 'Development',
                'slug' => 'development',
                'description' => 'Programming tutorials and development best practices',
                'color' => '#28a745',
                'icon' => 'fas fa-code',
                'meta_title' => 'Development Tutorials | Open Clusters',
                'meta_description' => 'Learn programming and development best practices with our tutorials.'
            ],
            [
                'name' => 'Mobile App',
                'slug' => 'mobile-app',
                'description' => 'Mobile application development and design',
                'color' => '#ffc107',
                'icon' => 'fas fa-mobile-alt',
                'meta_title' => 'Mobile App Development | Open Clusters',
                'meta_description' => 'Mobile app development guides and tutorials for iOS and Android.'
            ],
            [
                'name' => 'Cloud Technology',
                'slug' => 'cloud-technology',
                'description' => 'Cloud computing solutions and services',
                'color' => '#17a2b8',
                'icon' => 'fas fa-cloud',
                'meta_title' => 'Cloud Technology | Open Clusters',
                'meta_description' => 'Learn about cloud computing solutions and modern infrastructure.'
            ],
            [
                'name' => 'Security',
                'slug' => 'security',
                'description' => 'Cybersecurity best practices and solutions',
                'color' => '#dc3545',
                'icon' => 'fas fa-shield-alt',
                'meta_title' => 'Cybersecurity | Open Clusters',
                'meta_description' => 'Cybersecurity best practices and security solutions for businesses.'
            ]
        ];

        foreach ($categories as $category) {
            PostCategory::create($category);
        }

        // Create Tags
        $tags = [
            ['name' => 'Laravel', 'slug' => 'laravel', 'color' => '#ff2d20'],
            ['name' => 'Vue.js', 'slug' => 'vuejs', 'color' => '#4fc08d'],
            ['name' => 'React', 'slug' => 'react', 'color' => '#61dafb'],
            ['name' => 'PHP', 'slug' => 'php', 'color' => '#777bb4'],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'color' => '#f7df1e'],
            ['name' => 'CSS', 'slug' => 'css', 'color' => '#1572b6'],
            ['name' => 'HTML', 'slug' => 'html', 'color' => '#e34f26'],
            ['name' => 'Bootstrap', 'slug' => 'bootstrap', 'color' => '#563d7c'],
            ['name' => 'API', 'slug' => 'api', 'color' => '#009688'],
            ['name' => 'Database', 'slug' => 'database', 'color' => '#336791'],
            ['name' => 'SEO', 'slug' => 'seo', 'color' => '#ff6b35'],
            ['name' => 'UI/UX', 'slug' => 'ui-ux', 'color' => '#ff4081']
        ];

        foreach ($tags as $tag) {
            PostTag::create($tag);
        }

        // Create Posts
        $posts = [
            [
                'title' => 'Modern Web Design Trends for 2024',
                'slug' => 'modern-web-design-trends-2024',
                'excerpt' => 'Discover the latest web design trends that are shaping the digital landscape in 2024. From minimalist layouts to interactive elements.',
                'content' => '<p>Web design continues to evolve at a rapid pace, and 2024 has brought us some exciting new trends that are reshaping how we think about digital experiences. In this comprehensive guide, we\'ll explore the most impactful design trends that are defining the modern web.</p>

<h2>Minimalist Design with Maximum Impact</h2>
<p>Less is definitely more in 2024. Clean, uncluttered interfaces with plenty of white space are dominating the design landscape. This approach not only looks modern but also improves user experience by reducing cognitive load.</p>

<h2>Bold Typography</h2>
<p>Typography is taking center stage with large, bold fonts that make strong statements. Designers are experimenting with custom fonts and creative text layouts to create unique brand identities.</p>

<h2>Interactive Elements</h2>
<p>Static websites are becoming a thing of the past. Interactive elements like hover effects, micro-animations, and scroll-triggered animations are engaging users and creating memorable experiences.</p>

<p>The future of web design is bright, and these trends are just the beginning. As technology continues to advance, we can expect even more innovative approaches to digital design.</p>',
                'featured_image' => 'posts/web-design-trends-2024.jpg',
                'staff_id' => 2, // Sarah Johnson
                'post_category_id' => 1, // Web Design
                'meta_title' => 'Modern Web Design Trends 2024 | Latest Design Insights',
                'meta_description' => 'Explore the top web design trends for 2024 including minimalist design, bold typography, and interactive elements that are shaping the digital landscape.',
                'focus_keyword' => 'web design trends 2024',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::now()->subDays(5),
                'tags' => [1, 6, 7, 11] // CSS, HTML, SEO, UI/UX
            ],
            [
                'title' => 'Laravel Best Practices for Enterprise Applications',
                'slug' => 'laravel-best-practices-enterprise-applications',
                'excerpt' => 'Learn essential Laravel development practices that will make your enterprise applications more maintainable, secure, and scalable.',
                'content' => '<p>Laravel has become the go-to framework for enterprise PHP applications, but with great power comes great responsibility. Following best practices is crucial for building applications that can scale and be maintained over time.</p>

<h2>Project Structure and Organization</h2>
<p>A well-organized codebase is the foundation of any successful enterprise application. Use Laravel\'s built-in directory structure effectively and create custom directories when needed for better organization.</p>

<h2>Service Layer Pattern</h2>
<p>Implement a service layer to keep your controllers thin and your business logic organized. This approach makes your code more testable and maintainable.</p>

<h2>Database Design and Eloquent Best Practices</h2>
<p>Design your database schema carefully and use Eloquent relationships effectively. Avoid N+1 queries by using eager loading and implement proper indexing for better performance.</p>

<h2>Security Considerations</h2>
<p>Security should never be an afterthought. Use Laravel\'s built-in security features, validate all inputs, and implement proper authentication and authorization mechanisms.</p>',
                'featured_image' => 'posts/laravel-best-practices.jpg',
                'staff_id' => 1, // Daniel Martin
                'post_category_id' => 2, // Development
                'meta_title' => 'Laravel Best Practices 2024 | Enterprise Development Guide',
                'meta_description' => 'Master Laravel development with these enterprise-grade best practices covering security, performance, and maintainable code architecture.',
                'focus_keyword' => 'Laravel best practices',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::now()->subDays(10),
                'tags' => [1, 4, 9, 10] // Laravel, PHP, API, Database
            ],
            [
                'title' => 'Complete Guide to React Native App Development',
                'slug' => 'complete-guide-react-native-app-development',
                'excerpt' => 'Everything you need to know about React Native development, from setup to deployment across iOS and Android platforms.',
                'content' => '<p>React Native has revolutionized mobile app development by allowing developers to build native apps using JavaScript and React. This comprehensive guide will take you through the entire development process.</p>

<h2>Getting Started with React Native</h2>
<p>Setting up your development environment is the first step. We\'ll cover installation requirements for both iOS and Android development, including Xcode and Android Studio setup.</p>

<h2>Core Components and Navigation</h2>
<p>Learn about React Native\'s built-in components and how to implement navigation between screens using React Navigation library.</p>

<h2>State Management</h2>
<p>Explore different state management solutions including Redux, Context API, and newer alternatives like Zustand for managing application state effectively.</p>

<h2>Performance Optimization</h2>
<p>Discover techniques to optimize your React Native apps for better performance, including proper image handling, list optimization, and memory management.</p>

<h2>Deployment Process</h2>
<p>Learn how to deploy your apps to both App Store and Google Play Store, including code signing, build optimization, and release management.</p>',
                'featured_image' => 'posts/react-native-guide.jpg',
                'staff_id' => 3, // Michael Chen
                'post_category_id' => 3, // Mobile App
                'meta_title' => 'React Native Development Guide 2024 | Complete Tutorial',
                'meta_description' => 'Master React Native app development with this complete guide covering setup, development, performance optimization, and deployment.',
                'focus_keyword' => 'React Native development',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(15),
                'tags' => [3, 5, 9] // React, JavaScript, API
            ],
            [
                'title' => 'Cloud Computing Solutions for Modern Businesses',
                'slug' => 'cloud-computing-solutions-modern-businesses',
                'excerpt' => 'Explore how cloud computing is transforming business operations and discover the best cloud solutions for your organization.',
                'content' => '<p>Cloud computing has become an essential part of modern business infrastructure. Organizations of all sizes are leveraging cloud solutions to improve efficiency, reduce costs, and scale their operations.</p>

<h2>Types of Cloud Services</h2>
<p>Understanding the differences between Infrastructure as a Service (IaaS), Platform as a Service (PaaS), and Software as a Service (SaaS) is crucial for making informed decisions about your cloud strategy.</p>

<h2>Major Cloud Providers</h2>
<p>Compare the leading cloud providers including AWS, Microsoft Azure, and Google Cloud Platform, each offering unique advantages for different use cases.</p>

<h2>Migration Strategies</h2>
<p>Learn about different cloud migration approaches, from lift-and-shift to complete application modernization, and choose the right strategy for your organization.</p>

<h2>Cost Optimization</h2>
<p>Discover best practices for managing cloud costs, including resource optimization, automated scaling, and proper governance policies.</p>',
                'featured_image' => 'posts/cloud-computing-solutions.jpg',
                'staff_id' => 1, // Daniel Martin
                'post_category_id' => 4, // Cloud Technology
                'meta_title' => 'Cloud Computing Solutions 2024 | Business Cloud Guide',
                'meta_description' => 'Discover the best cloud computing solutions for modern businesses including AWS, Azure, and Google Cloud migration strategies.',
                'focus_keyword' => 'cloud computing solutions',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(20),
                'tags' => [9, 10] // API, Database
            ],
            [
                'title' => 'Essential Cybersecurity Best Practices for 2024',
                'slug' => 'cybersecurity-best-practices-2024',
                'excerpt' => 'Protect your business from cyber threats with these essential cybersecurity practices and modern security solutions.',
                'content' => '<p>As cyber threats continue to evolve, implementing robust cybersecurity measures has become more critical than ever. This guide covers the essential practices every business should implement to protect their digital assets.</p>

<h2>Zero Trust Security Model</h2>
<p>The traditional perimeter-based security model is no longer sufficient. Learn how to implement a zero trust approach that verifies every user and device before granting access.</p>

<h2>Multi-Factor Authentication</h2>
<p>MFA is one of the most effective security measures you can implement. Discover different types of authentication factors and how to roll them out across your organization.</p>

<h2>Employee Training and Awareness</h2>
<p>Human error remains one of the biggest security vulnerabilities. Learn how to create effective security awareness programs and foster a security-conscious culture.</p>

<h2>Incident Response Planning</h2>
<p>Being prepared for security incidents is crucial. Develop comprehensive incident response plans and regularly test them to ensure your team can respond effectively.</p>',
                'featured_image' => 'posts/cybersecurity-best-practices.jpg',
                'staff_id' => 1, // Daniel Martin
                'post_category_id' => 5, // Security
                'meta_title' => 'Cybersecurity Best Practices 2024 | Complete Security Guide',
                'meta_description' => 'Learn essential cybersecurity best practices for 2024 including zero trust security, MFA, and incident response planning.',
                'focus_keyword' => 'cybersecurity best practices',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(25),
                'tags' => [9] // API
            ]
        ];

        foreach ($posts as $postData) {
            $tags = $postData['tags'];
            unset($postData['tags']);

            $post = Post::create($postData);
            $post->tags()->attach($tags);
        }

        // Create Comments
        $comments = [
            [
                'post_id' => 1,
                'name' => 'John Smith',
                'email' => 'john@example.com',
                'content' => 'Great article! I particularly enjoyed the section on minimalist design. It really resonates with current user expectations.',
                'status' => 'approved',
                'created_at' => Carbon::now()->subDays(3)
            ],
            [
                'post_id' => 1,
                'name' => 'Emma Wilson',
                'email' => 'emma@example.com',
                'content' => 'The interactive elements trend is so important. Users expect more engaging experiences nowadays.',
                'status' => 'approved',
                'created_at' => Carbon::now()->subDays(2)
            ],
            [
                'post_id' => 2,
                'name' => 'David Chen',
                'email' => 'david@example.com',
                'content' => 'As a Laravel developer, I found this extremely helpful. The service layer pattern section was particularly insightful.',
                'status' => 'approved',
                'created_at' => Carbon::now()->subDays(1)
            ]
        ];

        foreach ($comments as $comment) {
            PostComment::create($comment);
        }
    }
}
