<?php
namespace App\Helpers;
use Illuminate\Support\Collection;

class AppHelper
{
    /**
     * Function: addScheme
     * Returns an url with http:// or https://
     */
    public static function addScheme($url, $scheme = 'http://')
    {
        if (empty($url))
        {
            return $url;
        }

        if (strpos($url, '@') !== false) {
            return $url;
        }
        return parse_url($url, PHP_URL_SCHEME) === null ? $scheme . $url : $url;
    }
    
    /**
     * Function: sanitize
     * Returns a sanitized string, typically for URLs.
     *
     * Parameters:
     *     $string - The string to sanitize.
     *     $force_lowercase - Force the string to lowercase?
     *     $anal - If set to *true*, will remove all non-alphanumeric characters.
     */
    public static function sanitizeFilename($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]", "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;", "â€”", "â€“", ",", "<", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
        
        return ($force_lowercase) ? (function_exists('mb_strtolower')) ? mb_strtolower($clean, 'UTF-8') : strtolower($clean) : $clean;
    }

    public static function transliterate($string = NULL)
    {
        $search = array(
            'ä', 'ö', 'ü', 'é', 'è', 'â', 'à', 'ç',
        );

        $replace = array(
            'ae', 'oe', 'ue', 'e', 'e', 'a', 'a', 'c',
        );
        
        return (string) str_replace($search, $replace, mb_strtolower($string, 'UTF-8'));
    }

    /**
     * Function: partition
     * Returns an array with equally distributed columns
     * 
     * @param array $data
     * @param string $groupBy
     */

    public static function partition($records, $groupBy = 'year', $cols = 3)
    {
        // determine group size
        $size = (int) ceil(count($records)/$cols);
       
        $chunks  = array_chunk($records->toArray(), $size);
        $columns = [];
        foreach($chunks as $chunk)
        {
            $collection = collect($chunk);
            $columns[] = $collection->flatten(1)->groupBy($groupBy);
        }

        return $columns;
    }
}