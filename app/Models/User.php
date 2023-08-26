<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



use \App\Models\Source;
use \App\Models\Category;
use \App\Models\Author;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     

    protected $fillable = [
        'username',
        'email',
        'password',
    ];
    */

    protected $guarded  = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];




    // User.php
    public function sources()
    {
        return $this->hasMany(Source::class, 'user_sources_table', 'user_id', 'source_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'user_categories_table', 'user_id', 'category_id')->withTimestamps();
    }

    // public function authors()
    // {
    //     return $this->hasMany(Author::class, 'user_authors');
    // }


}
