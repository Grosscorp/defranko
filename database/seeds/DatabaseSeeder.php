<?php

use App\LandingPage;
use App\LandingPageField;
use App\LandingPageFieldsText;
use App\LandingPageItem;
use App\Setting;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

//		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//
//		User::truncate();
//		LandingPage::truncate();
//		Setting::truncate();
//		LandingPageItem::truncate();
//		LandingPageField::truncate();
//		LandingPageFieldsText::truncate();
//
//		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		 $this->call('InitialSeeder');
	}

}
