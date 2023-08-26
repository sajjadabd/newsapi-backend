<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use \App\Models\User;
use \App\Models\Category;

class UserCategory extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function category() {
        return $this->belongsTo(Category::class , 'category_id');
    }
}
