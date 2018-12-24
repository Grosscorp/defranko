<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\File;
use App\Http\Controllers\ControllerTraits\ApiTrait;
use App\__SAMPLE__Recipe as Recipe;
use App\Repositories\__SAMPLE__RecipeRepository as RecipeRepository;
use App\Services\Transformer\__SAMPLE__RecipeTransformer as RecipeTransformer;
use App\Traits\FileSaver;
use App\Traits\Paginatable;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class RecipesController
 *
 * @package App\Http\Controllers\Api\Dashboard
 */
class __SAMPLE__RecipesController extends Controller
{
	use ApiTrait, FileSaver, Paginatable;
	/**
	 * @var RecipeRepository
	 */
	private $recipeRepository;
	/**
	 * @var RecipeTransformer
	 */
	private $recipeTransformer;

	/**
	 * RecipesController constructor.
	 *
	 * @param RecipeRepository  $recipeRepository
	 * @param RecipeTransformer $recipeTransformer
	 */
	public function __construct(RecipeRepository $recipeRepository, RecipeTransformer $recipeTransformer)
	{
		$this->recipeRepository = $recipeRepository;
		$this->recipeTransformer = $recipeTransformer;
	}


	/**
	 * @param $id
	 * @return array
	 */
	public function category($id)
	{
		$filters = [
			'category_id' => $id
		];

		$items = $this->recipeRepository->getList($filters, $this->getPaginationLimit('dashboard.recipes'));
		$data =  $this->recipeTransformer->transformCollection($items->toArray()['data']);

		$response = [
				'pagination' => $this->buildPagination($items),
				'list'       => $data
		];

		return $this->respond($response);
	}

	/**
	 * @param Requests\StoreRecipe $request
	 */
	public function store(Requests\StoreRecipe $request)
	{
		$data = $request->all();

		$recipe = Recipe::create($data);

		//add parent_id to files
		$this->createMediaByUser($data, $recipe->id);
	}

	/**
	 * @param                      $id
	 * @param Requests\StoreRecipe $request
	 */
	public function update($id, Requests\StoreRecipe $request)
	{
		$data = $request->all();

		$item = Recipe::findOrFail($id);

		$item->fill($data);

		$item->save();

		$parentCoverToken = false;

		if($item->avatar) {
			$parentCoverToken = $item->avatar['token'];
		}

		//add parent_id to files
		$this->updateMediaByUser($data, $id, $parentCoverToken);
	}

	/**
	 * @param $id
	 * @return mixed|\Symfony\Component\HttpFoundation\Response
	 */
	public function edit($id)
	{
		$item = Recipe::with('avatar','gallery')->findOrFail($id);

		if($item) {
			return $this->respond([
				'item' => $this->recipeTransformer->transform($item->toArray())
			]);
		} else {
			return $this->respondNotFound();
		}
	}

	public function delete($id)
	{
		$item = Recipe::findOrFail($id);

		$item->delete();

		//delete cover
		if($item->avatar && $item->avatar['token']) {
			File::findOrFail($item->avatar['id'])->update(['parent_id' => 0]);
		}

		//delete images
	}
}
