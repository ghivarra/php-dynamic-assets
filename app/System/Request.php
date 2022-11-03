<?php namespace Ghivarra;

/**
 * Request System
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

class Request
{
	public function getGet(string $key)
	{
		if (isset($_GET[$key]))
		{
			return empty($_GET[$key]) ? NULL : $_GET[$key];
		}

		return NULL;
	}

	//=================================================================================================================

	public function getPost(string $key)
	{
		if (isset($_POST[$key]))
		{
			return empty($_POST[$key]) ? NULL : $_POST[$key];
		}

		return NULL;
	}

	//=================================================================================================================
}