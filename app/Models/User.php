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




    public function sources()
    {
        return $this->belongsToMany(Source::class, 'user_sources', 'user_id', 'source_id')->withTimestamps();
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'user_categories', 'user_id', 'category_id')->withTimestamps();
    }



    /*

    // User.php
    public function sources() : HasManyThrough
    {
        // return $this->hasMany(Source::class, 'user_sources_table', 'user_id', 'source_id');

        return $this->hasManyThrough(
            UserSource::class,
            Source::class,
            'id', // Foreign key on the environments table...
            'user_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'source_id' // Local key on the environments table...
        );
    
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'user_categories_table', 'user_id', 'category_id');
    }

    // public function authors()
    // {
    //     return $this->hasMany(Author::class, 'user_authors');
    // }


    */

}
