<?php

/**
 * Routes Config
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

// load routing class
$route = new \Ghivarra\Routing();

// routes config
$route->add('/', 'App\\Controller\\HomeController::index');