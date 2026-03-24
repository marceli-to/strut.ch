<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectGridElement extends Model
{
    protected $fillable = [
        'position',
        'grid_id',
        'project_id',
        'project_image_id',
        'project_video_id'
    ];

    /**
     * Get the image for the element.
     */
    public function image()
    {
        return $this->hasOne('App\Models\ProjectImage', 'id', 'project_image_id');
    }

    /**
     * Get the video for the element.
     */
    public function video()
    {
        return $this->hasOne('App\Models\ProjectVideo', 'id', 'project_video_id');
    }

    /**
     * Scope a query to show elements by grid.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeByGrid($query, $grid_id)
    {
        return $query->where('grid_id', '=', $grid_id);
    } 

    /**
     * Scope a query to show elements by project.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeByProject($query, $project_id)
    {
        return $query->where('project_id', '=', $project_id);
    }
}
