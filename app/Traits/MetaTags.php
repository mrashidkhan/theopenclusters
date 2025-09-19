<?php

namespace App\Traits;

trait MetaTags
{
    protected $metaTags = [];

    /**
     * Set meta tags for the page
     */
    public function setMetaTags($data)
    {
        $defaults = [
            'title' => 'Open Clusters Systems',
            'description' => 'Open Clusters Systems: Empowering businesses with cutting-edge IT solutions tailored to your specific needs.',
            'keywords' => 'Application designing, IT Solutions, IT, Automation, Software, Digital Marketing',
            'image' => asset('img/logo.png'),
            'url' => request()->url(),
            'type' => 'website',
            'site_name' => 'Open Clusters Systems',
            'author' => 'Open Clusters Systems'
        ];

        $this->metaTags = array_merge($defaults, $data);

        // Share with all views
        view()->share('metaTags', $this->metaTags);

        return $this;
    }

    /**
     * Get meta tags
     */
    public function getMetaTags()
    {
        return $this->metaTags;
    }
}
