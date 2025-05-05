<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ["title", "slug", "description", "content", "cover_path", "status", "post_at", "category_id"];

    protected $casts = [
        'post_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, "post_tag");
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'post_like', 'post_id', 'user_id')->withTimestamps();
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_save_posts', 'post_id', 'user_id')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, "post_id");
    }
}
