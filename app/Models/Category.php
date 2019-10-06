<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['name', 'publish', 'show_types'];


    /**
     * Get the types for the category.
     */
    public function types()
    {
        return $this->hasMany('App\Models\CategoryType');
    }

    /**
     * Get the types for the category (published and ordered).
     */
    public function activeTypes()
    {
        return $this->hasMany('App\Models\CategoryType')
                    ->orderBy('order', 'ASC')
                    ->where('publish', '=', 1);
    }


    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }
}
