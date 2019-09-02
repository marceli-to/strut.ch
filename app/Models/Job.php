<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Job extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'lead', 'info', 'link', 'linkText', 'mediaCaption'];

    protected $fillable = ['title', 'lead', 'info',  'media', 'order', 'publish'];

}
