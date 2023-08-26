<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use \App\Models\Category;

class Category extends Model
{
    use HasFactory;

    protected $guarded  = [];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }


    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'user_categories_table', 'category_id', 'user_id');
    // }
}
