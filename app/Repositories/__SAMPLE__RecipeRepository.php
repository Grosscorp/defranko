<?php


namespace App\Repositories;
use App\Recipe;


/**
 * Class LandingPageFieldRepository
 *
 * @package App\Repositories
 */
class __SAMPLE__RecipeRepository
{
	/**
	 * @param array $filters
	 * @param       $limit
	 * @return mixed
	 */
	public function getList($filters = [], $limit)
	{
		$query = Recipe::with('avatar');

		$items = $this->applyFilters($query, $filters)->paginate($limit);

		return $items;
	}

	/**
	 * @param int $limit
	 * @return mixed
	 */
	public function getLast($limit = 6)
	{
		return Recipe::with('avatar')->orderBy('recipes.id', 'DESC')->take($limit)->get();
	}

	/**
	 * @param       $query
	 * @param array $filters
	 * @return mixed
	 */
	private function applyFilters($query, array $filters = [])
	{
		//searching by first name or last name or combined
		if (array_key_exists('category_id', $filters)) {
			$query->where('category_id', $filters['category_id']);
		}

		//ordering
		$query->orderBy('recipes.id', 'DESC');


		return $query;
	}
}
