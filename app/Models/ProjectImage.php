<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProjectImage extends Model
{
    use HasTranslations;

    public $translatable = [
        'caption'
    ];

    protected $fillable = [
        'name',
        'caption',
        'publish',
        'order',
        'is_preview_type',
        'is_preview_status',
        'is_preview_year',
        'is_grid',
        'project_id'
    ];

    /**
     * Relationship to projects
     */

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    /**
     * Scope a query to show elements by project.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeNotInGrid($query)
    {
        return $query->where('is_grid', '=', 0);
    } 
}
