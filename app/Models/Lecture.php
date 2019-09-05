<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Lecture extends Model
{
    use HasTranslations;
    
    public $translatable = ['title', 'description'];

    protected $fillable = ['title', 'description', 'year', 'media', 'publish'];

}