<?php namespace Ghivarra;

/**
 * Routing System
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

class Routing
{
	public static $rules = [];
	public static $class = [];
	public static $uri = '';

	//=================================================================================================

	public function add(string $slug = '/', string $class = '')
	{
		array_push(Routing::$rules, $slug);
		array_push(Routing::$class, $class);
	}

	//=================================================================================================

	public function parse()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$uri = (str_contains($uri, '?') == TRUE) ? strstr($uri, '?', TRUE) : $uri;
		$uri = (str_contains($uri, '#') == TRUE) ? strstr($uri, '#', TRUE) : $uri;
		$uri = explode('/', $uri);

		$slugs = [];

		foreach ($uri as $item):

			if (!empty($item))
			{
				array_push($slugs, $item);
			}

		endforeach;

		// put into uri
		$currentRoute = empty($slugs) ? '' : implode('/', $slugs);
		Routing::$uri = $currentRoute;

		// find in array
		if (!in_array($currentRoute, Routing::$rules))
		{
			$currentRoute = '/' . $currentRoute;

			if (!in_array($currentRoute, Routing::$rules))
			{
				die('Routes not found.');
			}
		}

		$key 		= array_search($currentRoute, Routing::$rules);
		$controller = Routing::$class[$key];
		$namespace  = '\\' . strstr($controller, '::', TRUE);
		$class      = substr($controller, (strpos($controller, '::') + 2));

		// load common file
		require APPPATH . 'Common.php';

		// call controller
		$controller = new $namespace();

		// return
		return $controller->$class();
	}

	//=================================================================================================
}