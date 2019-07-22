<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GridLayout extends Model
{
    /**
     * Scope for home grids
     */    
    public function scopeIsHome($query)
    {
        return $query->where('is_home', '=', 1);
    }  
}
