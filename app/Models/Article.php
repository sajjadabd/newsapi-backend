<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use \App\Models\Source;
use \App\Models\Category;

class Article extends Model
{
    use HasFactory;

    protected $guarded  = [];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

}
