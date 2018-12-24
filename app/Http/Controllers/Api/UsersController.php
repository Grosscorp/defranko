<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerTraits\ApiTrait;
use App\Http\Requests;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\Registrar;
use App\User;
use App\UserRole;

use Illuminate\Http\Request;

class UsersController extends Controller {

	use ApiTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->respond([
			'users' => User::all()
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{


		return $this->respond([
			'roles' => UserRole::lists('name', 'id')
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Registrar $registrar
	 * @param Request   $request
	 *
	 * @return Response
	 */
	public function store(Registrar $registrar, Request $request)
	{
		$validator = $registrar->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$registrar->create($request->all());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return $this->respond([
			'user' => User::find($id),
			'roles' => UserRole::lists('name', 'id')
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int              $id
	 * @param UpdateUserRequest $request
	 *
	 * @return Response
	 */
	public function update($id, UpdateUserRequest $request)
	{
		User::find($id)->update($request->all());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		User::destroy($id);
	}

	/**
	 * @param                       $id
	 * @param ChangePasswordRequest $request
	 */
	public function changePassword($id, ChangePasswordRequest $request)
	{
		User::find($id)->update([
			'password' => \Hash::make($request->all()['password'])
		]);
	}

}
