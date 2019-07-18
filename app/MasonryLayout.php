<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasonryLayout extends Model
{
    /**
     * Get the rows for the layout.
     */
    public function row()
    {
        return $this->hasMany('App\MasonryRow');
    }
}
