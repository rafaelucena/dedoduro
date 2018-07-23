<?php

namespace App\Http\Models;

use App\Models\Category;
use App\Models\Comment;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use Sluggable;
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'image', 'excerpt', 'description', 'views', 'user_id', 'is_active', 'allow_comments'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Custome scope for Active blogs.
     *
     * @return string
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Custome scope for Like Search.
     *
     * @return string
     */
    public function scopeLike($query, $field, $value)
    {
        return $query->where($field, 'LIKE', "%$value%");
    }

    /**
     * Custome scope for Or Like Search.
     *
     * @return string
     */
    public function scopeOrLike($query, $field, $value)
    {
        return $query->orWhere($field, 'LIKE', "%$value%");
    }

    /**
     * Get the user record associated with the blog.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the comments for the blog post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The category that belong to the blog.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
