<?php

use App\Setting;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFields extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Setting::create([
				'key' => 'email',
				'label' => 'Contact email',
				'value' => 'support@ukietech.net'
		]);
	}

}
