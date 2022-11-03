<?php namespace App\Controller;

/**
 * SASS Controller
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

use ScssPhp\ScssPhp\Compiler as SCSSCompiler;
use MatthiasMullie\Minify\CSS as CSSMinifier;

class SASSController extends BaseController
{
    public function index()
    {
        $path = func_get_args();
        $path = ASSETPATH . 'sass' . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $path);
        $path = str_ireplace('.css', '.scss', $path);

        if (!file_exists($path) OR !is_writable($path))
        {
            return $this->returnJSON('File not found or restricted.', 404);
        }

        $SCSSCompiler = new SCSSCompiler();
        $SCSSCompiler->setImportPaths(ROOTPATH . 'assets/sass/');

        // put on tmp file
        $randomPath = ROOTPATH . 'tmp' . DIRECTORY_SEPARATOR . random_string('alnum', 40) . '_' . time() . '.css';
        $cssFile    = fopen($randomPath, 'w+');
        fwrite($cssFile, $SCSSCompiler->compileString(file_get_contents($path))->getCss());
        fclose($cssFile);

        // minify
        $minifier = new CSSMinifier($randomPath);
        unlink($randomPath);

        // set header & return
        header('Content-Type: text/css');
        return $minifier->minify();
    }

    //=================================================================================================================
}