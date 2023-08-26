<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Article;

class Source extends Model
{
    use HasFactory;

    protected $guarded  = [];


    public function articles()
    {
        return $this->hasMany(Article::class);
    }


    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'user_sources_table', 'source_id', 'user_id');
    // }
}
