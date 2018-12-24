<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Fraank\ViewCounter\ViewCounterTrait;

/**
 * Class Recipe
 *
 * @package App
 */
class __SAMPLE__Recipe extends Model implements SluggableInterface
{
	use SluggableTrait, ViewCounterTrait;

	protected $sluggable = [
		'build_from' => 'title',
		'save_to'    => 'slug',
	];

	/**
	 * @var string
	 */
	protected $table = 'recipes';

	/**
	 * @var array
	 */
	protected $fillable = ['category_id', 'slug', 'title', 'text', 'seo_title', 'seo_description'];

	/**
	 * @return mixed
	 */
	public function gallery()
	{
		return $this->hasMany('App\File', 'parent_id')->where('type', \App\Repositories\FileRepository::FILE_RECIPE_IMAGE);
	}

	/**
	 * @return mixed
	 */
	public function avatar()
	{
		return $this->hasOne('App\File', 'parent_id', 'id')
				->where('type', \App\Repositories\FileRepository::FILE_RECIPE_COVER);
	}
}
