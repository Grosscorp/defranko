<?php namespace App;

use App\Repositories\FileRepository;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Fraank\ViewCounter\ViewCounterTrait;

/**
 * App\LandingPage
 *
 */
class LandingPage extends Model {

	use SluggableTrait, ViewCounterTrait;
	/**
	 * @var string
	 */
	protected $table = 'landing_pages';

	public $timestamps = false;

	/**
	 * @var array
	 */
	protected $fillable = ['token', 'parent_id', 'section', 'slug', 'coverToken'];


	/**
	 * Fields
	 */
	public function fields()
	{
		return $this->hasMany('App\LandingPageField', 'page_id');
	}

	/*
	 * Files
	 */
	public function files()
	{
		return $this->hasMany('App\File', 'parent_id');
	}

}
