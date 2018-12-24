<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLandingPages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('landing_pages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('token', 64)->unique()->nullable();
			$table->longText('text');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('landing_pages');
	}

}
