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
}
