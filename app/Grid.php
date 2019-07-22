<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grid extends Model
{
    protected $fillable = ['grid_layout_id', 'position'];

    /**
     * Get the layout associated with the row.
     */
    public function layout()
    {
        return $this->hasOne('App\GridLayout', 'id', 'grid_layout_id');
    }

    /**
     * Get the elements for the row.
     */
    public function elements()
    {
        return $this->hasMany('App\GridElement');
    }

}
