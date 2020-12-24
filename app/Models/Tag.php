<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // A tag can belong to many posts
    public function posts() {
        return $this->belongsToMany('App\Models\Post');
    }

    public function filteredPosts() {
        return $this->belongsToMany('App\Models\Post')
        ->wherePivot('tag_id', $this->id)
        ->orderBy('updated_at', 'DESC');
        // ^ Looking in the intermediate table of postTags to identify 
        // which tag_id matches the id and ordering by latest updated at
    }

    protected $fillable = [
        'name',
        'style',
    ];
}
