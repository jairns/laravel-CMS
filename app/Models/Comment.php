<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // A comment can only have one user
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    // A comment can only have one post
    public function post() {
        return $this->belongsTo('App\Models\Post');
    }

    protected $fillable = [
        'comment',
        'user_id',
        'post_id'
    ];


}
