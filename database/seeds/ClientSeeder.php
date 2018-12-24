<?php

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		//GENERATE USER FOR CLIENT. UNCOMMENT LATER
//		User::create([
//			'id' => '2',
//			'role_id' => UserRepository::USER_ROLE_ADMIN,
//			'name' => 'some user name',
//			'email' => 'mail@userdomain.com',
//			'password' => Hash::make('UserPassWord')
//		]);
	}

}
