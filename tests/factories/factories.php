<?php

$factory('App\LandingPage', [
	'token' => $faker->word,
	'text'	=> $faker->text()
]);

$factory('App\LandingPageItem', [
	'parent_id' => 'factory:App\LandingPage',
	'section' => $faker->word,
	'token'	=> $faker->word,
	'name' => $faker->word,
	'note1' => $faker->sentence,
	'note2' => $faker->sentence,
	'text1' => $faker->text(),
	'text2' => $faker->text(),
	'text3' => $faker->text()
]);


$factory('App\LandingPageItem', 'blog', [
	'parent_id' => 'factory:App\LandingPage',
	'section' => 'blog',
	'name' => $faker->words(5),
	'slug' => $faker->slug,
	'text1' => $faker->realText(500),
	'text2' => $faker->realText(5000)
]);
