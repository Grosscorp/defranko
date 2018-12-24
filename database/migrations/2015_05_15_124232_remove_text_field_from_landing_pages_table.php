<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveTextFieldFromLandingPagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('landing_pages', function (Blueprint $table) {
			$table->dropColumn('text');
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
			$table->longText('text');
		});
	}
}
