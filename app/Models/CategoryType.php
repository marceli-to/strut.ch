<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CategoryType extends Model
{
    use HasTranslations;

    public $translatable = ['name_singular', 'name_plural'];

    protected $fillable = ['category_id', 'name_singular', 'name_plural', 'order', 'visible'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
