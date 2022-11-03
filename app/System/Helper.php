<?php 

/**
 * Global Helper
 *
 * "I treat my works as my own child, be careful with my childrens"
 *
 * Created with love and proud by Ghivarra Senandika Rushdie
 *
 * @package Company Profile Website
 *
 * @var https://github.com/ghivarra
 * @var https://facebook.com/bcvgr
 * @var https://twitter.com/ghivarra
 *
**/

/**
 *
 * Check String Exist
 *
 * @return bool
 *
**/
if (!function_exists('str_contains'))
{
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== FALSE;
    }
}

/**
 *
 * Kint and exit
 *
 * @return bool
 *
**/
if (!function_exists('dd'))
{
    function dd($data) {
        d($data);
        exit;
    }
}