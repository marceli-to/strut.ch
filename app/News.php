<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class News extends Model
{
    use HasTranslations;

    public $translatable = ['date', 'title', 'text', 'link', 'linkText', 'mediaCaption'];

    protected $fillable = ['date', 'title', 'text', 'link', 'linkText', 'media', 'mediaCaption'];

}
