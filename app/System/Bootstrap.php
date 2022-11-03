<?php 

// load helper and path
require ROOTPATH . 'app/System/Path.php';
require ROOTPATH . 'app/System/Helper.php';

// load vendor
require ROOTPATH . 'vendor/autoload.php';

// load dotenv
$dotenv = Dotenv\Dotenv::createImmutable(ROOTPATH);
$dotenv->safeLoad();
define('ENV', $_ENV['ENVIRONMENT']);

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
ob_end_flush();

// put memory get usage
if (ENV == 'development')
{
	$peak = memory_get_peak_usage();
	$peak = round(($peak / 1000000), 2) . ' MB';

	$file = fopen(ROOTPATH . 'tmp/memory.txt', 'w+');
	fwrite($file, $peak);
	fclose($file);

	// set time
	$time = floor(microtime(true) * 1000) - START;
	$time = round(($time / 1000), 3);

	$file = fopen(ROOTPATH . 'tmp/time.txt', 'w+');
	fwrite($file, $time . ' Detik');
	fclose($file);

	// unset
	unset($file);
}