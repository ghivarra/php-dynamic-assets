<?php namespace App\Controller;

/**
 * Base Controller
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

use Ghivarra\Request;

class BaseController
{
    public function __construct()
    {
        $this->request = new Request();
    }

    //=================================================================================================================

    public function returnJSON($data = '', $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');

        return json_encode($data);
    }

    //=================================================================================================================
}