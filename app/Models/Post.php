<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Traits\SEOHelper;

class Post extends Model
{
    use HasFactory, SEOHelper;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'featured_image', 'gallery_images',
        'staff_id', 'post_category_id', 'meta_title', 'meta_description', 'meta_keywords',
        'focus_keyword', 'canonical_url', 'og_title', 'og_description', 'og_image',
        'og_type', 'twitter_title', 'twitter_description', 'twitter_image',
        'schema_data', 'status', 'is_featured', 'allow_comments', 'published_at',
        'views_count', 'reading_time'
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'schema_data' => 'array',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }

            // Auto-calculate reading time
            if (!empty($post->content) && empty($post->reading_time)) {
                $post->reading_time = self::calculateReadingTime($post->content);
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }

            if ($post->isDirty('content')) {
                $post->reading_time = self::calculateReadingTime($post->content);
            }
        });
    }

    // Relationships
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function author()
    {
        return $this->staff();
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(PostTag::class, 'post_post_tag');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(PostComment::class)->where('status', 'approved');
    }

    public function parentComments()
    {
        return $this->hasMany(PostComment::class)->whereNull('parent_id')->where('status', 'approved');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function ($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    public function scopeByTag($query, $tagSlug)
    {
        return $query->whereHas('tags', function ($q) use ($tagSlug) {
            $q->where('slug', $tagSlug);
        });
    }

    public function scopeByAuthor($query, $authorSlug)
    {
        return $query->whereHas('staff', function ($q) use ($authorSlug) {
            $q->where('slug', $authorSlug);
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('content', 'LIKE', "%{$search}%")
              ->orWhere('excerpt', 'LIKE', "%{$search}%");
        });
    }

    // Accessors
    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : asset('img/blog-default.jpg');
    }

    public function getExcerptAttribute($value)
    {
        return $value ?: Str::limit(strip_tags($this->content), 150);
    }

    public function getReadingTimeTextAttribute()
    {
        return $this->reading_time . ' min read';
    }

    public function getPublishedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('d M Y') : null;
    }

    public function getPublishedDateTimeAttribute()
    {
        return $this->published_at ? $this->published_at->format('M d, Y \a\t h:i A') : null;
    }

    // SEO Methods - Enhanced with SEOHelper trait
    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    public function getMetaDescriptionAttribute($value)
    {
        return $value ?: Str::limit(strip_tags($this->excerpt), 160);
    }

    public function getOgTitleAttribute($value)
    {
        return $value ?: $this->meta_title;
    }

    public function getOgDescriptionAttribute($value)
    {
        return $value ?: $this->meta_description;
    }

    public function getOgImageAttribute($value)
    {
        return $value ?: $this->featured_image_url;
    }

    // Helper Methods
    public static function calculateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        $averageWordsPerMinute = 200;
        return max(1, ceil($wordCount / $averageWordsPerMinute));
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function getRelatedPosts($limit = 3)
    {
        return self::published()
                   ->where('id', '!=', $this->id)
                   ->where(function ($query) {
                       $query->where('post_category_id', $this->post_category_id)
                             ->orWhereHas('tags', function ($q) {
                                 $q->whereIn('post_tag_id', $this->tags->pluck('id'));
                             });
                   })
                   ->orderBy('published_at', 'desc')
                   ->limit($limit)
                   ->get();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
