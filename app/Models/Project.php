<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Project extends Model
{
    use HasTranslations;

    public $translatable = [
        'name',
        'location',
        'description',
        'info'
    ];

    protected $fillable = [
        'name',
        'location',
        'description',
        'info',
        'year',
        'has_detail',
        'status',
        'competition',
        'publish',
        'order',
        'category_id',
        'category_type_id',
        'order'
    ];

    /**
     * Relationships
     */

    public function images()
    {
        return $this->hasMany('App\Models\ProjectImage');
    }

    public function downloads()
    {
        return $this->hasMany('App\Models\ProjectFile');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function categoryType()
    {
        return $this->belongsTo('App\Models\CategoryType');
    }
}

