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

		User::create([
			'role_id' => UserRepository::USER_ROLE_ADMIN,
			'name' => 'admin',
			'email' => 'support@ukietech.net',
			'password' => Hash::make('ukie12345')
		]);
	}

}
