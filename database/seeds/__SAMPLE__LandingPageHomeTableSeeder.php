<?php

use App\LandingPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

// composer require laracasts/testdummy
//use Laracasts\TestDummy\Factory as TestDummy;

class LandingPageHomeTableSeeder extends SeederCommon
{

	public function run()
	{
		Model::unguard();

		$faker = Faker::create();

		$options = [];

		//first page sub blocks

		//Services blocks
		for($i = 1; $i < 3; $i++) {
			$options[] = [
				'fieldKey' => 'sub_block_' . $i,
				'value' => $faker->realText(100),
				'type' => 'textarea',
				'label' => 'First Page Sub Block#' . $i
			];
		}


		//Services blocks
		for($i = 1; $i < 6; $i++) {
			$options[] = [
				'fieldKey' => 'adv_block_title_' . $i,
				'value' => $faker->sentence(),
				'type' => 'textbox',
				'label' => 'Advantages Block#' . $i . ' Title',
				'maxLength' => 100
			];

			$options[] = [
				'fieldKey' => 'adv_block_text_' . $i,
				'value' => $faker->realText(500),
				'type' => 'textarea',
				'label' => 'Advantages Block#' . $i . ' Text'
			];
		}

		$options = $this->addSeoOptions($options);

		LandingPage::create([
			'token' => 'home',
			'text' => base64_encode(serialize( $options ))
		]);

		$this->call('TestimonialsSeeder');
	}

}
