<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeGridElement extends Model
{
    protected $fillable = ['grid_id', 'project_image_id', 'news_id', 'position'];

    /**
     * ProjectImage relationship
     */

    public function projectimage()
    {
        return $this->hasOne('App\Models\ProjectImage', 'id', 'project_image_id');
    }

    /**
     * News relationship
     */

    public function news()
    {
        return $this->hasOne('App\Models\News', 'id', 'news_id');
    }
}
