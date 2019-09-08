<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProjectFile extends Model
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
