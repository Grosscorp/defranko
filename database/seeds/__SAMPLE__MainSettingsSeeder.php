<?php

use App\LandingPage;
use App\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class MainSettingsSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$faker = Faker::create();

		Setting::create([
			'key' => 'email',
			'label' => 'Contact email',
			'value' => 'support@ukietech.net'
		]);

		Setting::create([
			'key' => 'phone',
			'label' => 'Contact phone',
			'value' => $faker->phoneNumber
		]);

		Setting::create([
			'key' => 'fb',
			'label' => 'Facebook profile link',
			'value' => $faker->url
		]);

		Setting::create([
			'key' => 'in',
			'label' => 'Linkedin profile link',
			'value' => $faker->url
		]);

		Setting::create([
			'key' => 'tw',
			'label' => 'Twitter profile link',
			'value' => $faker->url
		]);


//		$this->call('LandingPageHomeSeeder');
	}

}
