<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Services\AuthenticateUser;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Default redirect url after login
	 * @var string
	 */
	protected $redirectTo = '/afterLogin';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => ['getLogout', 'afterLogin']]);
	}


	/**
	 * AJAX POST persist login
	 * @param AuthLoginRequest $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
//	public function postLogin(AuthLoginRequest $request)
//	{
//		$response = [];
//		$credentials = $request->only('email', 'password');
//
//		if ($this->auth->attempt($credentials, $request->has('remember'))) {
//			$response['redirect'] = $this->redirectPath();
//			$response['success'] = true;
//			$response['item'] = \Auth::user()->toArray();
//		} else {
//			$response['success'] = false;
//			$response['message'] = $this->getFailedLoginMessage();
//		}
//
//		return response()->json($response);
//	}

	/**
	 * AJAX POST persist register
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
//	public function postRegister(Request $request)
//	{
//		$response = [];
//		$validator = $this->registrar->validator($request->all());
//
//		if ($validator->fails())
//		{
//			$this->throwValidationException(
//				$request, $validator
//			);
//		}
//
//		$this->auth->login($this->registrar->create($request->all()));
//
//		$response['redirect'] = $this->redirectPath();
//
//		return response()->json($response);
//	}

	/**
	 * Facebook login
	 * @param AuthenticateUser $authenticateUser
	 * @param Request          $request
	 *
	 * @return mixed
	 */
	public function loginViaFacebook(AuthenticateUser $authenticateUser, Request $request)
	{
		return $authenticateUser->execute($authenticateUser::LOGIN_TYPE_FB ,$request->has('code'), $this);
	}

	/**
	 * Google plus login
	 * @param AuthenticateUser $authenticateUser
	 * @param Request          $request
	 *
	 * @return mixed
	 */
	public function loginViaGoogle(AuthenticateUser $authenticateUser, Request $request)
	{
		return $authenticateUser->execute($authenticateUser::LOGIN_TYPE_GOOGLE ,$request->has('code'), $this);
	}

	/**
	 * Callback after user logged in
	 * @param $user
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function userHasLoggedIn($user)
	{
		if($user->isAdmin()) {
			return redirect('/dashboard');
		} else {
			return redirect()->back();
		}

//		//go to main page
//		if(isset($user->profile->isCompleted) && $user->profile->isCompleted) {
//			return redirect('/profile');
//		} else {
//			//if not complete profile yet - than go to completion
//			return redirect('/profile/complete');
//		}
	}
	//After login action for simple login - not social
	public function afterLogin()
	{
		return $this->userHasLoggedIn(\Auth::user());
	}

}
