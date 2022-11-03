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
		Routing::$uri = $currentRoute;
	}

	//=================================================================================================

	public function parse()
	{
		$currentRoute = '';
		$findMatched  = FALSE;
		$params       = [];

		foreach (Self::$rules as $num => $item):

			if ($findMatched)
			{
				break;
			}

			$ruleItems = [];
			$ruleItem  = explode('/', $item);

			if (empty($ruleItem) OR empty(Self::$slugs))
			{
				continue;
			}

			foreach ($ruleItem as $val)
			{
				if (!empty($val))
				{
					array_push($ruleItems, $val);
				}
			}

			if (empty($ruleItems))
			{
				continue;
			}

			foreach ($ruleItems as $n => $val)
			{
				if (!isset(Self::$slugs[$n]))
				{
					$currentRoute = '';
					break;
				}

				if ($val == Self::$slugs[$n] OR $val === '(:any)')
				{
					$currentRoute .= '/' . $val;

					if ($val !== '(:any)')
					{
						continue;
					}

					if ($val === '(:any)')
					{
						foreach (Self::$slugs as $x => $slug):

							if ($x >= $n)
							{
								array_push($params, $slug);
							}

						endforeach;

						$findMatched = TRUE;
						break;
					}

				} else {

					break;
				}
			}

		endforeach;

		// find in array
		if (!in_array($currentRoute, Self::$rules))
		{
			$currentRoute = '/' . $currentRoute;

			if (!in_array($currentRoute, Self::$rules))
			{
				die('Routes not found.');

			} else {

				$key = array_search($currentRoute, Self::$rules);
			}

		} else {

			$key = array_search($currentRoute, Self::$rules);
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