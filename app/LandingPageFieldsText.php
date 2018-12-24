<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\LandingPageFieldsText
 *
 */
class LandingPageFieldsText extends Model {

	protected $table = 'landing_page_fields_text';
	public $timestamps = false;

	protected $fillable = ['field_id', 'lang', 'value'];

}
