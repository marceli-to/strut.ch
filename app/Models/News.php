<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class News extends Model
{
    use HasTranslations;

    public $translatable = [
        'date',
        'subtitle',
        'title',
        'text',
        'link',
        'linkText'
    ];

    protected $fillable = [
        'date',
        'subtitle',
        'title',
        'text',
        'link',
        'linkText',
        'media'
    ];

}
