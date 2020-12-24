<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    // A post belongs to one user
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
    // A post can have many tags
    public function tags() {
        return $this->belongsToMany('App\Models\Tag');
    }

    // A post can have many comments
    public function comments () {
        return $this->hasMany('App\Models\Comment');
    }

    protected $fillable = [
        'title',
        'description',
        'content',
        'user_id'
    ];
}
