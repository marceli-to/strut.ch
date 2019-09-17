<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeGrid extends Model
{
    protected $fillable = ['layout_id', 'order', 'publish'];

    /**
     * Get the layout associated with the row.
     */

    public function layout()
    {
        return $this->hasOne('App\Models\HomeGridLayout', 'id', 'layout_id');
    }

    /**
     * Get the elements for the row.
     */

    public function elements()
    {
        return $this->hasMany('App\Models\HomeGridElement');
    }
}
