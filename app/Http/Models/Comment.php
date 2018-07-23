<?php

namespace App\Models;

use App\Http\Models\Blog;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'body', 'blog_id', 'is_active'
    ];

    /**
     * Get the blog that owns the comment.
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
