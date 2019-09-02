<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Team extends Model
{
    use HasTranslations;

    protected $table = 'team';

    public $translatable = ['role', 'position', 'cv'];

    protected $fillable = ['name', 'firstname', 'role',  'position', 'phone', 'email', 'cv', 'media', 'order', 'publish'];

}
