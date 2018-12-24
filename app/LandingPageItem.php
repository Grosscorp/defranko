<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\LandingPageItem
 *
 */
class LandingPageItem extends Model {

	protected $table = 'landing_page_items';

	public $timestamps = false;

	/**
	 * @var array
	 */
	protected $fillable = ['parent_id', 'section', 'token', 'slug', 'coverToken', 'name', 'note1', 'note2', 'note3', 'note4', 'text1', 'text2', 'text3' ];

	/**
	 * @param $parentId
	 *
	 * @return mixed
	 */
	public static function getByParentId($parentId)
	{
		return static::whereParentId($parentId)->get();
	}

}
