<?php namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Contracts\Auth\Guard;

/**
 * Class Dashboard
 *
 * @package App\Http\Middleware
 */
class Dashboard {

	/**
	 * @var Guard
	 */
	protected $auth;

	/**
	 * @param Guard $auth
	 */
	function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(! $this->auth->user()->isAdmin()) {
//			return response('Unauthorized.', 401);
			return redirect('/auth/login');
		}

		return $next($request);
	}

}
