<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'slug', 'position', 'bio', 'avatar',
        'phone', 'social_links', 'status'
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    // Automatically generate slug when creating/updating
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($staff) {
            if (empty($staff->slug)) {
                $staff->slug = Str::slug($staff->name);
            }
        });

        static::updating(function ($staff) {
            if ($staff->isDirty('name') && empty($staff->slug)) {
                $staff->slug = Str::slug($staff->name);
            }
        });
    }

    // Relationships
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function publishedPosts()
    {
        return $this->hasMany(Post::class)->where('status', 'published');
    }

    // Accessors
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : asset('img/admin.jpg');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
