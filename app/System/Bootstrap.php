<?php 

// load helper and path
require ROOTPATH . 'app/System/Path.php';
require ROOTPATH . 'app/System/Helper.php';

// load vendor
require ROOTPATH . 'vendor/autoload.php';

// load dotenv
$dotenv = Dotenv\Dotenv::createImmutable(ROOTPATH);
$dotenv->safeLoad();

// output buffer start
ob_start();

// load routing
require ROOTPATH . 'app/System/Routing.php';
require ROOTPATH . 'app/Config/Routes.php';

// start routing
$routing = new \Ghivarra\Routing();

// returning data
echo $routing->parse();

// done output buffer
ob_flush();