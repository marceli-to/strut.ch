<?php

namespace App\Helpers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class ImageHelper
{
  static function get($image = NULL, $size = 'sm')
  {
    $directories = [
      'xs' => 'xsmall',
      'sm' => 'small',
      'md' => 'medium',
      'lg' => 'large'
    ];
    
    // Default src
    $src = '/media/' . $image . '/' . $size;

    // Overwrite with real image path
    if (File::exists(storage_path('app/public/media/' . $directories[$size] . '/') . $image))
    {
      $src = '/storage/media/' . $directories[$size] . '/' . $image;
    }

    return $src;
  }
}