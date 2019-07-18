<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasonryRow extends Model
{
    protected $fillable = ['masonry_layout_id', 'position'];

    /**
     * Get the layout associated with the row.
     */
    public function layout()
    {
        return $this->hasOne('App\MasonryLayout', 'id', 'masonry_layout_id');
    }

    /**
     * Get the elements for the row.
     */
    public function elements()
    {
        return $this->hasMany('App\MasonryElement');
    }
}
