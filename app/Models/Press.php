<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Press extends Model
{
    use HasTranslations;
    
    protected $table = 'press';

    public $translatable = [
        'title',
        'description'
    ];

    protected $fillable = [
        'title', 
        'description', 
        'year', 
        'url', 
        'media', 
        'publish', 
        'file', 
        'project_id'
    ];

    public function project()
    {
        return $this->hasOne('App\Models\Project', 'id', 'project_id');
    }

    /**
     * Get only published records
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopePublished($query)
    {
        return $query->where('publish', '=', '1');
    }

}
