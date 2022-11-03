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

// store uri
$routing = new \Ghivarra\Routing();
$routing->storeUri();

// load routes config
require ROOTPATH . 'app/Config/Routes.php';

// returning data
echo $routing->parse();

// done output buffer
ob_flush();