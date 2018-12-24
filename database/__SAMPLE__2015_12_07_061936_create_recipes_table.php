<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recipes', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('category_id')->unsigned();
			$table->string('slug')->unique();

			$table->string('title');
			$table->longText('text');
			$table->string('seo_title');
			$table->text('seo_description');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('recipes');
	}
}
