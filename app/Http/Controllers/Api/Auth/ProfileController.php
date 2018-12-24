<?php namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerTraits\ApiTrait;
use App\Http\Requests;

use App\User;
use Illuminate\Http\Request;

/**
 * Class ProfileController
 *
 * @package App\Http\Controllers\Api\Auth
 */
class ProfileController extends Controller {

	use ApiTrait;

	public function __construct()
	{
		$this->middleware('auth', ['except' => 'index']);
		$this->middleware('member', ['except' => 'index']);
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(\Auth::user()) {
			return $this->respond([
				'item' => \Auth::user()->toArray()
			]);
		} else {
			return $this->respond([
				'item' => false
			]);
		}
	}
}
