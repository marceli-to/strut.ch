<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\JpegEncoder;

class MediaService
{
    /**
     * Image manager instance
     */
    protected $manager;

    /**
     * Path for source files
     */
    protected $path_source;

    /**
     * Path for uploads
     */
    protected $path_uploads;

    /**
     * Path for small images
     */
    protected $path_xsmall;

    /**
     * Path for small images
     */
    protected $path_small;

    /**
     * Path for large images
     */
    protected $path_large;

    /**
     * Path for thumbnails
     */
    protected $path_thumbs;

    /**
     * Size for square thumbnails
     */
    protected $size_thumbs = 200;

    /**
     * Size for square small images
     */    
    protected $size_sm = 600;

    /**
     * Maximum width for extra small landscape images
     */    
    protected $max_width_xs = 500;    

    /**
     * Maximum height for extra small portrait images
     */    
    protected $max_height_xs = 350;

    /**
     * Maximum width for small landscape images
     */    
    protected $max_width_sm = 900;    

    /**
     * Maximum height for small portrait images
     */    
    protected $max_height_sm = 500;

    /**
     * Maximum width for medium landscape images
     */    
    protected $max_width_md = 1200;    

    /**
     * Maximum height for medium portrait images
     */    
    protected $max_height_md = 800;

    /**
     * Maximum width for large landscape images
     */    
    protected $max_width_lg = 1600;    

    /**
     * Maximum height for large portrait images
     */    
    protected $max_height_lg = 1100;

    /**
     * Image quality
     */
    protected $quality = 90;

    /**
     * Image prefix
     */
    protected $prefix = 'strut.ch';

    /**
     * Cache expiry time in seconds (7 days)
     */
    protected $cache_ttl = 604800;
    
    public function __construct()
    {
        // Initialize the ImageManager with GD driver
        $this->manager = new ImageManager(new GdDriver());
        
        $this->path_source    = storage_path('app/public/media/');
        $this->path_xsmall    = storage_path('app/public/media/xsmall/');
        $this->path_small     = storage_path('app/public/media/small/');
        $this->path_medium    = storage_path('app/public/media/medium/');
        $this->path_large     = storage_path('app/public/media/large/');
        $this->path_thumbs    = storage_path('app/public/media/thumbs/');
        $this->path_grid      = storage_path('app/public/media/grid/');
        $this->path_downloads = storage_path('app/public/media/downloads');
        $this->path_uploads   = storage_path('app/public/tmp/uploads');
        $this->_mkdir();
    }

    /**
     * Upload the specified resource.
     *
     * @return array
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $name = $this->_sanitizeFilename(trim($file->getClientOriginalName()), true, true);
        $name = uniqid() . '_' . $this->prefix . '_' . $name;
        $file->move($this->path_source, $name);

        // Get file extension to store in media model
        $filetype = File::extension($this->path_source . $name);

        // Create thumbnail for preview
        $this->thumbnail($name);

        return ['name' => $name, 'filetype' => $filetype];
    }

    /**
     * Upload the specified resource.
     *
     * @return array
     */
    public function uploadDocument(Request $request)
    {
        $file = $request->file('file');
        $name = $this->_sanitizeFilename(trim($file->getClientOriginalName()), true, true);
        $name = uniqid() . '_' . $name;
        $file->move($this->path_downloads, $name);

        // Get file extension to store in media model
        $filetype = File::extension($this->path_downloads . $name);

        return ['name' => $name, 'filetype' => $filetype];
    }

    /**
     * Generate a thumbnail image.
     * 
     * @param  str $image
     * @return \Illuminate\Http\Response
     */
    public function thumbnail($image = null)
    {
        $cacheKey = 'thumb_' . $image;
        
        // If thumbnail doesn't exist, create it
        if (!File::exists($this->path_thumbs . $image)) {
            // Create image instance
            $img = $this->manager->read($this->path_source . $image);
            
            // Resize the image to fit the dimensions
            $img = $img->cover($this->size_thumbs, $this->size_thumbs);
            
            // Save the image
            $img->save($this->path_thumbs . $image, new JpegEncoder($this->quality));
            
            // Store the image data in cache
            $imageData = file_get_contents($this->path_thumbs . $image);
            Cache::put($cacheKey, $imageData, $this->cache_ttl);
            
            return response($imageData, 200, ['Content-Type' => 'image/jpeg']);
        } else {
            // Check if image is in cache
            if (Cache::has($cacheKey)) {
                $imageData = Cache::get($cacheKey);
            } else {
                $imageData = file_get_contents($this->path_thumbs . $image);
                Cache::put($cacheKey, $imageData, $this->cache_ttl);
            }
            
            return response($imageData, 200, ['Content-Type' => 'image/jpeg']);
        }
    }

    /**
     * Generate grid size image
     * 
     * @param  str $image
     * @return \Illuminate\Http\Response
     */
    public function grid($image = null)
    {
        if ($image != null) {
            $cacheKey = 'grid_' . $image;
            
            // If grid image doesn't exist, create it
            if (!File::exists($this->path_grid . $image)) {
                // Create image instance
                $img = $this->manager->read($this->path_source . $image);
                
                // Resize the image
                $img = $img->scale(height: 90);
                
                // Save the image
                $img->save($this->path_grid . $image, new JpegEncoder($this->quality));
                
                // Store the image data in cache
                $imageData = file_get_contents($this->path_grid . $image);
                Cache::put($cacheKey, $imageData, $this->cache_ttl);
                
                return response($imageData, 200, ['Content-Type' => 'image/jpeg']);
            } else {
                // Check if image is in cache
                if (Cache::has($cacheKey)) {
                    $imageData = Cache::get($cacheKey);
                } else {
                    $imageData = file_get_contents($this->path_grid . $image);
                    Cache::put($cacheKey, $imageData, $this->cache_ttl);
                }
                
                return response($imageData, 200, ['Content-Type' => 'image/jpeg']);
            }
        }
    }

    /**
     * Resize an image.
     * 
     * @param  str $image
     * @param  str $size
     * @return \Illuminate\Http\Response
     */
    public function resize($image, $size = 'sm')
    {
        if ($image != null) {
            $cacheKey = $size . '_' . $image;
            $targetPath = '';
            $maxWidth = 0;
            $maxHeight = 0;
            
            // Set target path and dimensions based on size
            switch ($size) {
                case 'xs':
                    $targetPath = $this->path_xsmall;
                    $maxWidth = $this->max_width_xs;
                    $maxHeight = $this->max_height_xs;
                    break;
                case 'sm':
                    $targetPath = $this->path_small;
                    $maxWidth = $this->max_width_sm;
                    $maxHeight = $this->max_height_sm;
                    break;
                case 'md':
                    $targetPath = $this->path_medium;
                    $maxWidth = $this->max_width_md;
                    $maxHeight = $this->max_height_md;
                    break;
                case 'lg':
                    $targetPath = $this->path_large;
                    $maxWidth = $this->max_width_lg;
                    $maxHeight = $this->max_height_lg;
                    break;
                default:
                    $targetPath = $this->path_small;
                    $maxWidth = $this->max_width_sm;
                    $maxHeight = $this->max_height_sm;
            }
            
            // If resized image doesn't exist, create it
            if (!File::exists($targetPath . $image)) {
                // Create image instance
                $img = $this->manager->read($this->path_source . $image);
                
                // Get width and height
                $width = $img->width();
                $height = $img->height();
                
                // Resize image according to orientation
                if ($width > $height && $width >= $maxWidth) {
                    $img = $img->scale(width: $maxWidth);
                } elseif ($height >= $maxHeight) {
                    $img = $img->scale(height: $maxHeight);
                }
                
                // Save the image
                $img->save($targetPath . $image, new JpegEncoder($this->quality));
                
                // Store the image data in cache
                $imageData = file_get_contents($targetPath . $image);
                Cache::put($cacheKey, $imageData, $this->cache_ttl);
                
                return response($imageData, 200, ['Content-Type' => 'image/jpeg']);
            } else {
                // Check if image is in cache
                if (Cache::has($cacheKey)) {
                    $imageData = Cache::get($cacheKey);
                } else {
                    $imageData = file_get_contents($targetPath . $image);
                    Cache::put($cacheKey, $imageData, $this->cache_ttl);
                }
                
                return response($imageData, 200, ['Content-Type' => 'image/jpeg']);
            }
        }
    }

    /**
     * Delete a file from the storage, including all subfolders
     * 
     * @param str $filename
     */
    public function delete($filename)
    {
        $directories = Storage::allDirectories('public');
        foreach ($directories as $d) {
            Storage::delete($d . '/'. $filename);
        }
        
        // Clear any cached versions
        Cache::forget('thumb_' . $filename);
        Cache::forget('grid_' . $filename);
        Cache::forget('xs_' . $filename);
        Cache::forget('sm_' . $filename);
        Cache::forget('md_' . $filename);
        Cache::forget('lg_' . $filename);
    }

    /**
     * Sanitize a string
     *
     * @param str $string
     * @param boolean  $force_lowercase - Force the string to lowercase?
     * @param boolean  $anal - If set to *true*, will remove all non-alphanumeric characters.
     */
    private function _sanitizeFilename($string, $force_lowercase = true, $anal = false)
    {
        $strip = ['~', '`', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '=', '+', '[', '{', ']', '}', '\\', '|', ';', ':', '"', "'", '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#8211;', '&#8212;', 'â€"', 'â€"', ',', '<', '>', '/', '?'];
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9.\-_]/", "", $clean) : $clean;
        return ($force_lowercase) ? (function_exists('mb_strtolower')) ? mb_strtolower($clean, 'UTF-8') : strtolower($clean) : $clean;
    }

    /**
     * Create directories
     * 
     */
    private function _mkdir()
    {
        if (!File::isDirectory($this->path_uploads)) {
            File::makeDirectory($this->path_uploads, 0775, true, true);
        }

        if (!File::isDirectory($this->path_downloads)) {
            File::makeDirectory($this->path_downloads, 0775, true, true);
        }
        
        if (!File::isDirectory($this->path_source)) {
            File::makeDirectory($this->path_source, 0775, true, true);
        }

        if (!File::isDirectory($this->path_thumbs)) {
            File::makeDirectory($this->path_thumbs, 0775, true, true);
        }

        if (!File::isDirectory($this->path_grid)) {
            File::makeDirectory($this->path_grid, 0775, true, true);
        }

        if (!File::isDirectory($this->path_xsmall)) {
            File::makeDirectory($this->path_xsmall, 0775, true, true);
        }

        if (!File::isDirectory($this->path_small)) {
            File::makeDirectory($this->path_small, 0775, true, true);
        }

        if (!File::isDirectory($this->path_medium)) {
            File::makeDirectory($this->path_medium, 0775, true, true);
        }

        if (!File::isDirectory($this->path_large)) {
            File::makeDirectory($this->path_large, 0775, true, true);
        }
    }
}