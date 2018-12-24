<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersAddRoleId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->integer('role_id')->unsigned()->after('id');

			$table->foreign('role_id')
				->references('id')->on('user_roles')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table)
		{
			$table->dropForeign('users_role_id_foreign');
			$table->dropColumn('role_id');
		});
	}

}
