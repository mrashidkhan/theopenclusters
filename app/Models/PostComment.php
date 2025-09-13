<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id', 'parent_id', 'name', 'email', 'website',
        'ip_address', 'user_agent', 'content', 'status',
        'is_featured', 'likes_count', 'dislikes_count'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    // Relationships
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function parent()
    {
        return $this->belongsTo(PostComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(PostComment::class, 'parent_id');
    }

    public function approvedReplies()
    {
        return $this->hasMany(PostComment::class, 'parent_id')->where('status', 'approved');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeReplies($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    // Accessors
    public function getAvatarAttribute()
    {
        return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '?d=mm&s=50';
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getIsReplyAttribute()
    {
        return !is_null($this->parent_id);
    }

    public function getRepliesCountAttribute()
    {
        return $this->approvedReplies()->count();
    }

    // Methods
    public function approve()
    {
        $this->update(['status' => 'approved']);
    }

    public function reject()
    {
        $this->update(['status' => 'rejected']);
    }

    public function markAsSpam()
    {
        $this->update(['status' => 'spam']);
    }
}
