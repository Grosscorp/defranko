<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRole
 *
 * @package App
 */
class UserRole extends Model {

	/**
	 * @var string
	 */
	protected $table = 'user_roles';

	/**
	 * @var array
	 */
	protected $fillable = ['name'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
//	public function user()
//	{
//		return $this->hasMany('App\User');
//	}

}
