<?php

namespace DealsBundle\Services;

class UtilesService
{
    /**
     * @param $text
     * @return string|string[]
     */
    public function slugify($text)
    {
        try {
            // replace non letter or digits by -
            $text = preg_replace('#[^\\pL\d]+#u', '-', $text);
            // trim
            $text = trim($text, '-');
            // transliterate
            if (function_exists('iconv'))
            {
                $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
            }
            // lowercase
            $text = strtolower($text);
            // remove unwanted characters
            $text = preg_replace('#[^-\w]+#', '', $text);
            if (empty($text))
            {
                return 'n-a';
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $text;
    }
}