<?php namespace App\Controller;

/**
 * Javascript Controller
 *
 * "I treat my works as my own child, be careful with my childrens"
 *
 * Created with love and proud by Ghivarra Senandika Rushdie
 *
 * @package PHP Dynamic Assets
 *
 * @var https://github.com/ghivarra
 * @var https://facebook.com/bcvgr
 * @var https://twitter.com/ghivarra
 *
**/

use MatthiasMullie\Minify\JS as JSMinifier;

class JavascriptController extends BaseController
{
    public function index()
    {
        $path = func_get_args();
        $path = ASSETPATH . 'js' . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $path);

        if (!file_exists($path) OR !is_writable($path))
        {
            return $this->returnJSON('File not found or restricted.', 404);
        }

        // minify
        $minifier = new JSMinifier($path);

        // set header & return
        header('Content-Type: text/javascript');
        return $minifier->minify();
    }

    //=================================================================================================================
}