<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Content extends Model
{
    use HasTranslations;
    
    protected $table = 'content';

    public $translatable = [
        'title',
        'text',
    ];

    protected $fillable = [
        'key',
        'title',
        'text',
        'media',
        'publish',
        'hasMedia',
    ];

    /**
     * Relationships
     */

    public function images()
    {
        return $this->hasMany('App\Models\ContentImage');
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
