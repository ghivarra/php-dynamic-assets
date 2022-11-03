<?php namespace App\Controller;

/**
 * Home Controller
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

class HomeController extends BaseController
{
	public function index()
	{
		$data = [
			'hello' => $this->request->getGet('hello')
		];

		dd($data);
	}

	//=================================================================================================================
}