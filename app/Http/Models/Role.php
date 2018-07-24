<?php

namespace App\Http\Models;

use App\Http\Models\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role', 'description'
    ];

    /**
     * The Users that belong to the Role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
