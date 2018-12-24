<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswords;

	protected $redirectTo = '/';

	/**
	 * Create a new password controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
	 */
	public function __construct(Guard $auth, PasswordBroker $passwords)
	{
		$this->auth = $auth;
		$this->passwords = $passwords;

		$this->middleware('guest');
	}

	/**
	 * AJAX POST email
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function postEmail(Request $request)
	{
		$this->validate($request, ['email' => 'required|email']);

		$response = $this->passwords->sendResetLink($request->only('email'), function($m)
		{
			$m->subject($this->getEmailSubject());
		});

		$resp = [];

		switch ($response)
		{
			case PasswordBroker::RESET_LINK_SENT:
				$resp['message'] = trans($response);
				break;

			case PasswordBroker::INVALID_USER:
				$resp['message'] = trans($response);
				break;
		}
		return response()->json($resp);
	}

	/**
	 * AJAX POST reset
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function postReset(Request $request)
	{
		$this->validate($request, [
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|confirmed',
		]);

		$credentials = $request->only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = $this->passwords->reset($credentials, function($user, $password)
		{
			$user->password = bcrypt($password);

			$user->save();

			$this->auth->login($user);
		});

		$resp = [];

		switch ($response)
		{
			case PasswordBroker::PASSWORD_RESET:
				$resp['redirect'] = $this->redirectPath();
				break;

			default:
				$resp['message'] = trans($response);
		}

		return response()->json($resp);
	}

}
