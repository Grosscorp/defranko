<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\LandingPageField
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\LandingPageFieldsText[] $texts 
 */
class LandingPageField extends Model {

	public $timestamps = false;

	protected $fillable = ['page_id', 'key', 'type', 'label', 'editor', 'position'];

	/**
	 * Text value
	 */
	public function texts()
	{
		return $this->hasMany('App\LandingPageFieldsText', 'field_id');
	}

}
