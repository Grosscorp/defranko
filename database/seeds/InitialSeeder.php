<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class InitialSeeder extends Seeder
{
	public function run()
	{
		$this->call('AdminSeeder');
	}
}
