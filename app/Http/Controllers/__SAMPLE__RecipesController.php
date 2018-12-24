<?php

namespace App\Http\Controllers;

use App\__SAMPLE__Recipe as Recipe;
use App\Repositories\LandingPageRepository;
use App\Repositories\__SAMPLE__RecipeRepository as RecipeRepository;
use App\Services\Transformer\__SAMPLE__RecipeTransformer as RecipeTransformer;
use App\Traits\PageSeo;
use App\Traits\Paginatable;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class __SAMPLE__RecipesController extends Controller
{
	use PageSeo,Paginatable;
	/**
	 * @var RecipeRepository
	 */
	private $recipeRepository;
	/**
	 * @var RecipeTransformer
	 */
	private $transformer;

	/**
	 * RecipesController constructor.
	 *
	 * @param RecipeRepository  $recipeRepository
	 * @param RecipeTransformer $transformer
	 */
	public function __construct(RecipeRepository $recipeRepository, RecipeTransformer $transformer)
	{
		parent::__construct();
		$this->recipeRepository = $recipeRepository;
		$this->transformer = $transformer;
	}

	public function index(LandingPageRepository $landingPageRepository)
	{
		$recipes = $this->recipeRepository->getList([], 2);

		$data = [
			'items' => $recipes
		];

		$page = $landingPageRepository->getByToken('recipes');
		$fields = $landingPageRepository->transformPage($page);

		$seo_title = $this->getSeoAttributeFromFields($fields, 'seo_title');
		$seo_description = $this->getSeoAttributeFromFields($fields, 'seo_description');

		$data = array_merge($data, compact('seo_title', 'seo_description', 'fields'));


		return view('pages.recipes.list', $data);
	}

	public function category($id)
	{
		if(array_key_exists($id, array_flip(array_keys(trans('recipes.categories')))) === false) {
			abort(404, 'Category not found');
		}

		$filters = [
			'category_id' => $id
		];

		$recipes = $this->recipeRepository->getList($filters, $this->getPaginationLimit('public.recipes'));

		$seo_title = trans('recipes.categories.' . $id) . ' - Recipes';

		$data = [
			'items' => $recipes
		];

		$data = array_merge($data, compact('seo_title'));

		return view('pages.recipes.list', $data);
	}

	public function show($slug)
	{
		$item = Recipe::whereSlug($slug)->with('avatar','gallery')->first();
		$item->view();

		$data = [
			'item' => $this->transformer->transform($item->toArray()),
			'itemObj' => $item
		];

		$seo_title = $item->title . ' - Recipes';

		$data = array_merge($data, compact('seo_title'));

		return view('pages.recipes.show', $data);
	}
}
