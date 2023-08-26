<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use \App\Models\User;
use \App\Models\Source;

class UserSource extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function source() {
        return $this->belongsTo(Source::class , 'source_id');
    }
}
