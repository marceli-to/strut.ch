<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body'];
    
    /**
     * Get the images for the post.
     */
    public function media()
    {
        return $this->hasMany('App\PostMedia');
    }
}
