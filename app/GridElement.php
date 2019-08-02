<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GridElement extends Model
{
    protected $fillable = ['grid_id', 'post_media_id', 'news_id', 'position'];

    /**
     * Get the elements for the row.
     */
    public function postmedia()
    {
        return $this->hasOne('App\PostMedia', 'id', 'post_media_id');
    }

    public function news()
    {
        return $this->hasOne('App\News', 'id', 'news_id');
    }
}
