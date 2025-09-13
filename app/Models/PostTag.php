<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'color',
        'meta_title', 'meta_description', 'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });

        static::updating(function ($tag) {
            if ($tag->isDirty('name') && empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

    // Relationships
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_post_tag');
    }

    public function publishedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_post_tag')
                    ->where('posts.status', 'published');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->withCount('publishedPosts')
                    ->orderBy('published_posts_count', 'desc')
                    ->limit($limit);
    }

    // Accessors
    public function getPostsCountAttribute()
    {
        return $this->posts()->count();
    }

    public function getPublishedPostsCountAttribute()
    {
        return $this->publishedPosts()->count();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
