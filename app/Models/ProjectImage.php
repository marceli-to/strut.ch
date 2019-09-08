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
        'project_id'
    ];

    /**
     * Relationships
     */

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
}
