<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Setting
 *
 */
class Setting extends Model {

	/**
	 * @var string
	 */
	protected $table = 'settings';

	public $timestamps = false;

	/**
	 * @var array
	 */
	protected $fillable = ['key', 'label', 'value', 'type', 'isRoot', 'position'];

}
