<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class News extends Model
{
    use HasTranslations;

    public $translatable = [
        'date',
        'title',
        'text',
        'link',
        'linkText'
    ];

    protected $fillable = [
        'date',
        'title',
        'text',
        'link',
        'linkText',
        'media'
    ];

}
