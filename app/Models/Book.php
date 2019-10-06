<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Book extends Model
{
    use HasTranslations;

    public $translatable = [
        'description', 
        'info'
    ];

    protected $fillable = [
        'title',
        'description', 
        'info', 
        'url', 
        'media', 
        'order', 
        'publish'
    ];

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
