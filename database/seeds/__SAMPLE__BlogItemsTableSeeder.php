<?php

use App\LandingPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class BlogItemsTableSeeder extends SeederCommon
{

	public function run()
	{
		Model::unguard();
		$parent = LandingPage::getByToken('blog');

		//CREATE ENTITY FIRST AT /test/factories/factories.php
		TestDummy::times(4)->create('blog', ['parent_id' => $parent->id]);

		$this->call('LandingPageFleetTableSeeder');
	}

}
