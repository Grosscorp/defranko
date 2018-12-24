<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	protected $lang;

	function __construct()
	{
		$this->lang = \Session::get('locale', LANG_EN);
	}

	public function getLang()
	{
		return $this->lang;
	}
}
