<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GridElement extends Model
{
    protected $fillable = ['grid_id', 'post_media_id', 'article_id', 'position'];

    /**
     * Get the elements for the row.
     */
    public function postmedia()
    {
        return $this->hasOne('App\PostMedia', 'id', 'post_media_id');
    }
}
