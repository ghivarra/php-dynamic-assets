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
    function str_contains($haystack, $needle)
    {
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
    function dd($data)
    {
        d($data);
        exit;
    }
}

/**
* Create a Random String
*
* Useful for generating passwords or hashes.
*
* @param string $type Type of random string.  basic, alpha, alnum, numeric, nozero, md5, sha1, and crypto
* @param int    $len  Number of characters
*/

if (! function_exists('random_string'))
{
    function random_string(string $type = 'alnum', int $len = 8): string
    {
        switch ($type) {
            case 'alnum':
            case 'numeric':
            case 'nozero':
            case 'alpha':
                switch ($type) {
                    case 'alpha':
                        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;

                    case 'alnum':
                        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;

                    case 'numeric':
                        $pool = '0123456789';
                        break;

                    case 'nozero':
                        $pool = '123456789';
                        break;
                }

                return substr(str_shuffle(str_repeat($pool, (int) ceil($len / strlen($pool)))), 0, $len);

            case 'md5':
                return md5(uniqid((string) mt_rand(), true));

            case 'sha1':
                return sha1(uniqid((string) mt_rand(), true));

            case 'crypto':
                if ($len % 2 !== 0) {
                    throw new InvalidArgumentException(
                        'You must set an even number to the second parameter when you use `crypto`.'
                    );
                }

                return bin2hex(random_bytes($len / 2));
        }
        // 'basic' type treated as default
        return (string) mt_rand();
    }
}