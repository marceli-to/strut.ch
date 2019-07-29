<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostMedia extends Model
{
    protected $fillable = ['post_id', 'name', 'caption', 'filetype', 'order'];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
