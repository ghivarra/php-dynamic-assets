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
	public static $slugs = [];
	public static $uri   = '';

	//=================================================================================================

	public function add(string $slug = '/', string $class = '')
	{
		array_push(Routing::$rules, $slug);
		array_push(Routing::$class, $class);
	}

	//=================================================================================================

	public function storeUri()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$uri = (str_contains($uri, '?') == TRUE) ? strstr($uri, '?', TRUE) : $uri;
		$uri = (str_contains($uri, '#') == TRUE) ? strstr($uri, '#', TRUE) : $uri;
		$uri = explode('/', $uri);

		foreach ($uri as $item):

			if (!empty($item))
			{
				array_push(Self::$slugs, $item);
			}

		endforeach;

		// put into uri
		$currentRoute = empty(Self::$slugs) ? '' : implode('/', Self::$slugs);
		Self::$uri = $currentRoute;
	}

	//=================================================================================================

	public function parse()
	{
		$findMatched  = FALSE;
		$params       = [];

		// reverse array
		$checkedItem = [];

		if (!empty(Self::$slugs) > 0)
		{
			$slugs = Self::$slugs;
			$uri   = '';

			foreach ($slugs as $n => $item):

				$uri = str_ireplace('/(:any)', '', $uri);
				$uri .= '/' . $item;

				array_push($checkedItem, $uri);

				if (isset($slugs[($n + 1)]))
				{
					array_push($checkedItem, "{$uri}/(:any)");
				}

			endforeach;
		}

		// reverse
		$checkedItem = array_reverse($checkedItem);

		if (!empty($checkedItem))
		{
			foreach ($checkedItem as $n => $item):

				if (in_array($item, Self::$rules))
				{
					$findMatched = TRUE;
					$key = array_search($item, Self::$rules);
					$num = $n;
					break;
				}

			endforeach;

			if ($findMatched)
			{
				$rules   = str_replace('/(:any)', '', Self::$rules[$key]);
				$realURI = Self::$uri;
				$realURI = substr($realURI, strlen($rules));
				$params  = explode('/', $realURI);
			}
		}

		// if not matched
		if (!$findMatched)
		{
			$currentRoute = '';

			if (!in_array($currentRoute, Self::$rules))
			{
				$currentRoute = '/';

				if (!in_array($currentRoute, Self::$rules))
				{
					die('Routes not found.');

				} else {

					$key = array_search($currentRoute, Self::$rules);
				}

			} else {

				$key = array_search($currentRoute, Self::$rules);
			}
		}

		$controller = Self::$class[$key];
		$namespace  = '\\' . strstr($controller, '::', TRUE);
		$class      = substr($controller, (strpos($controller, '::') + 2));

		// load common file
		require APPPATH . 'Common.php';

		// call controller
		if (!class_exists($namespace))
		{
			die('Controller not found.');
		}

		$controller = new $namespace();

		if (!method_exists($controller, $class))
		{
			die('Method not found.');
		}

		// return
		return $controller->$class(...$params);
	}

	//=================================================================================================
}