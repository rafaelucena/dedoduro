<?php

namespace App\Http\Models;

use App\Http\Models\Blog;
use App\Http\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
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
     * The category that belong to the blogs.
     */
    public function blogs()
    {
        return $this->belongsToMany(Blog::class);
    }

    /**
     * Get the user record associated with the category.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
