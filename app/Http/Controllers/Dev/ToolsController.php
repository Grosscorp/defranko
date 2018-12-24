<?php
namespace App\Http\Controllers\Dev;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class ToolsController
 *
 * @package App\Http\Controllers\Dev
 */
class ToolsController extends Controller
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function emailRender()
	{
		$faker = \Faker\Factory::create();

		return view('emails/NewSubscription/SendEmailToAdmin', [
			'data' => [
				'first_name' => $faker->firstName,
				'last_name' => $faker->lastName,
				'phone' => $faker->phoneNumber,
				'email' => $faker->email,
				'message' => $faker->text()
			]
		]);
	}
}
