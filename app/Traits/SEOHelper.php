<?php

namespace App\Traits;

trait SEOHelper
{
    /**
     * Generate meta tags for the current page
     */
    public function getMetaTags()
    {
        $metaTags = [
            'title' => $this->meta_title ?: $this->title,
            'description' => $this->meta_description ?: $this->getDefaultDescription(),
            'keywords' => $this->meta_keywords,
            'canonical' => $this->canonical_url ?: request()->url(),
            'og_title' => $this->og_title ?: $this->meta_title ?: $this->title,
            'og_description' => $this->og_description ?: $this->meta_description ?: $this->getDefaultDescription(),
            'og_image' => $this->og_image ?: $this->getDefaultImage(),
            'og_type' => $this->og_type ?: 'article',
            'og_url' => request()->url(),
            'twitter_title' => $this->twitter_title ?: $this->og_title,
            'twitter_description' => $this->twitter_description ?: $this->og_description,
            'twitter_image' => $this->twitter_image ?: $this->og_image,
        ];

        return array_filter($metaTags); // Remove null values
    }

    /**
     * Get default description if none provided
     */
    protected function getDefaultDescription()
    {
        if (isset($this->excerpt)) {
            return strip_tags($this->excerpt);
        }

        if (isset($this->content)) {
            return \Illuminate\Support\Str::limit(strip_tags($this->content), 160);
        }

        if (isset($this->description)) {
            return strip_tags($this->description);
        }

        return config('app.name') . ' - ' . $this->title;
    }

    /**
     * Get default image if none provided
     */
    protected function getDefaultImage()
    {
        if (isset($this->featured_image) && $this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }

        return asset('img/og-default.jpg');
    }

    /**
     * Generate structured data (JSON-LD)
     */
    public function getStructuredData()
    {
        if ($this->schema_data) {
            return $this->schema_data;
        }

        // Default Article schema
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $this->title,
            'description' => $this->getDefaultDescription(),
            'image' => $this->getDefaultImage(),
            'datePublished' => isset($this->published_at) ? $this->published_at->toISOString() : $this->created_at->toISOString(),
            'dateModified' => $this->updated_at->toISOString(),
            'author' => [
                '@type' => 'Person',
                'name' => isset($this->staff) ? $this->staff->name : config('app.name')
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('img/logo.png')
                ]
            ]
        ];
    }

    /**
     * Render meta tags as HTML
     */
    public function renderMetaTags()
    {
        $metaTags = $this->getMetaTags();
        $html = '';

        // Basic meta tags
        if (isset($metaTags['title'])) {
            $html .= '<title>' . e($metaTags['title']) . '</title>' . "\n";
        }

        if (isset($metaTags['description'])) {
            $html .= '<meta name="description" content="' . e($metaTags['description']) . '">' . "\n";
        }

        if (isset($metaTags['keywords'])) {
            $html .= '<meta name="keywords" content="' . e($metaTags['keywords']) . '">' . "\n";
        }

        if (isset($metaTags['canonical'])) {
            $html .= '<link rel="canonical" href="' . e($metaTags['canonical']) . '">' . "\n";
        }

        // Open Graph tags
        $html .= '<meta property="og:title" content="' . e($metaTags['og_title']) . '">' . "\n";
        $html .= '<meta property="og:description" content="' . e($metaTags['og_description']) . '">' . "\n";
        $html .= '<meta property="og:image" content="' . e($metaTags['og_image']) . '">' . "\n";
        $html .= '<meta property="og:type" content="' . e($metaTags['og_type']) . '">' . "\n";
        $html .= '<meta property="og:url" content="' . e($metaTags['og_url']) . '">' . "\n";

        // Twitter Card tags
        $html .= '<meta name="twitter:card" content="summary_large_image">' . "\n";
        $html .= '<meta name="twitter:title" content="' . e($metaTags['twitter_title']) . '">' . "\n";
        $html .= '<meta name="twitter:description" content="' . e($metaTags['twitter_description']) . '">' . "\n";
        $html .= '<meta name="twitter:image" content="' . e($metaTags['twitter_image']) . '">' . "\n";

        return $html;
    }

    /**
     * Render structured data as JSON-LD
     */
    public function renderStructuredData()
    {
        $structuredData = $this->getStructuredData();
        return '<script type="application/ld+json">' . json_encode($structuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>';
    }
}
