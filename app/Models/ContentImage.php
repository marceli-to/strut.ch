<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentImage extends Model
{
    protected $table = 'content_images';

    protected $fillable = [
        'name',
        'caption',
        'publish',
        'order',
        'content_id'
    ];

    /**
     * Relationship to projects
     */

    public function content()
    {
        return $this->belongsTo('App\Models\content');
    }
}
