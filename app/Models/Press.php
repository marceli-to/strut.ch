<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Press extends Model
{
    use HasTranslations;
    
    protected $table = 'press';

    public $translatable = ['title', 'description'];

    protected $fillable = ['title', 'description', 'year', 'url', 'media', 'publish'];

}
