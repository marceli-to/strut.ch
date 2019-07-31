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

    /**
     * Scope a query to only get elements not used in grids.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNoGridElement($query)
    {
        return $query->where('isGridElement', '=', 0);
    }
}
