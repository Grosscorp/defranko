<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToLandingPagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('landing_pages', function (Blueprint $table) {
			$table->integer('parent_id')->unsigned()->nullable();
			$table->string('section', '64')->nullable();
			$table->string('slug')->nullable();
			$table->string('coverToken', '8')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('landing_pages', function (Blueprint $table) {
			$table->dropColumn('parent_id');
			$table->dropColumn('section');
			$table->dropColumn('slug');
			$table->dropColumn('coverToken');
		});
	}
}
