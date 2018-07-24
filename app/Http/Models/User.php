<?php

namespace App\Models;

use App\Http\Models\Blog;
use App\Http\Models\Category;
use App\Http\Models\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'about', 'confirmation_token', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Custome scope for Active Users.
     *
     * @return string
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Get the blogs record associated with the user.
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    /**
     * Get the category record associated with the user.
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * The Roles that belong to the Users.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
    * Check one role
    * @param string $role
    */
    public function hasRole($role)
    {
        return null !== $this->roles()->where('role', $role)->first();
    }
}
