<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CategoryType extends Model
{
    use HasTranslations;

    public $translatable = ['name_singular', 'name_plural'];

    protected $fillable = ['category_id', 'name_singular', 'name_plural', 'order'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * Get the projects for the type.
     */
    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }

    /**
     * Get the projects for the type (published and ordered).
     */
    public function activeProjects()
    {
        return $this->hasMany('App\Models\Project')
                    ->orderBy('order', 'ASC')
                    ->where('publish', '=', 1);
    }
}
