<?php namespace App\Http\Controllers\Api;

use App\File;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerTraits\ApiTrait;
use App\Http\Requests;

use App\Http\Requests\StoreLandingPageRequest;
use App\LandingPage;
use App\Repositories\FileRepository;
use App\Repositories\LandingPageFieldRepository;
use App\Repositories\LandingPageRepository;
use App\Traits\FileSaver;
use App\Transformers\LandingPageTransformer;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\SluggableTrait;

class LandingPagesController extends Controller {

	use FileSaver, ApiTrait;
	/**
	 * @var
	 */
	protected $transformer;

	function __construct(LandingPageTransformer $transformer)
	{
		$this->transformer = $transformer;
	}

	public function listByParent($parentId, $section, LandingPageRepository $landingPageRepository)
	{
		$page = LandingPage::find($parentId);
		$items = $landingPageRepository->getByParentId($parentId, $section);

		$this->additionalShowBySection($page->token, $section, $items);

		$response = [
			'data' => $items
		];

		return $this->respond($response);
	}

	public function create($section)
	{
		$response = [
			'fields' => \Config::get('landing.' .$section . '.options')
		];


		return $this->respond($response);
	}


	/**
	 * @param                       $token
	 *
	 * @param LandingPageRepository $landingPageRepository
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function show($token, LandingPageRepository $landingPageRepository)
	{
		$page = $landingPageRepository->getByToken($token);

		if(! $page) {
			return $this->respondNotFound('Page does not exists');
		}

		$response = [
			'data' => $page
		];

		$this->additionalShow($token, $response, $page);


		return $this->respond($response);
	}



	/**
	 * @param                       $token
	 * @param LandingPageRepository $landingPageRepository
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function editByToken($token, LandingPageRepository $landingPageRepository)
	{
		$page = $landingPageRepository->getByToken($token);

		return $this->editHelper($page);
	}

	public function getByTokenAndSection($token, $section, LandingPageRepository $landingPageRepository)
	{
		$items = $landingPageRepository->getByTokenAndSection($token, $section);

		return $this->respond([
			'list' => $items->toArray()
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param                       $id
	 * @param LandingPageRepository $landingPageRepository
	 *
	 * @return Response
	 */
	public function edit($id, LandingPageRepository $landingPageRepository)
	{
		$page = $landingPageRepository->getById($id);
		return $this->editHelper($page);
	}

	/**
	 * Edit master page or page with elements
	 */
//	public function editPage($token, $section = false, LandingPageRepository $landingPageRepository)
//	{
//		if($section) { //get master page element
////			$masterPage = LandingPage::where('token', $token);
//			//todo
//		} else {
//			//master page
//			$page = $landingPageRepository->getByToken($token);
//			return $this->editHelper($page);
//		}
//	}

	private function editHelper($page)
	{
		if(! $page) {
			return $this->respond([]);
//			return $this->respondNotFound('Page does not exists');
		}

//		$images = FileRepository::getByParentId($page->id, File::FILE_ABOUT_LANDING);

		return $this->respond([
			'fields' => $page->fields,
			'item'	=> $page
//			'images' => FileRepository::transformWithDimensionUrls($images)
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param                            $id
	 * @param StoreLandingPageRequest    $request
	 *
	 * @param LandingPageFieldRepository $landingPageFieldRepository
	 *
	 * @return Response
	 */
//	public function update($id, StoreLandingPageRequest $request, LandingPageFieldRepository $landingPageFieldRepository)
//	{
//		$data = $request->all();
//
//		$page = LandingPage::find($id);
//
//		$landingPageFieldRepository->updateFields($page->id, $data['lang'], $data['fields']);
//
//		$this->additionalUpdate($page->token, $page,
//			isset($data['gallery'])
//				? $data['gallery']
//				: []
//		);
//	}

	public function updateAllLangs($id, StoreLandingPageRequest $request, LandingPageFieldRepository $landingPageFieldRepository)
	{
		$data = $request->all();

		$page = LandingPage::find($id);

		foreach($data['items'] as $langFields) {
			$landingPageFieldRepository->updateFields($page->id, $langFields['lang'], $langFields['fields']);
		}

//		if(
//			(!empty($data['coverToken']) || ($page->coverToken && empty($data['coverToken']))) //cover was added or removed
//			&& $data['coverToken'] != $page->coverToken
//		) {
//			FileRepository::setParentIdByToken($data['coverToken'], $page->id);
//			FileRepository::setParentIdByToken($page->coverToken, null);
//		}

		$this->updateMediaByUser($data, $id, $page->coverToken);

		$page->coverToken = isset($data['coverToken']) ? $data['coverToken'] : null;
		$page->save();


//		$this->additionalUpdate($page->token, $page,
//			isset($data['gallery'])
//				? $data['gallery']
//				: []
//		);
	}



	public function store(Request $request, LandingPageFieldRepository $landingPageFieldRepository)
	{
		$data = $request->all();

		if(!empty($data['section'])) {
			if(!empty($data['token'])) {
				$masterPage = LandingPage::where('token', $data['token'])->first();
				$data['parent_id'] = $masterPage['id'];
				unset($data['token']);
			}
		}

		$page = LandingPage::create($data);

		//check if slug is needed via config
		if(!empty($data['section'])) {
			if(array_key_exists('slug', config('pages.' . $data['section']))) {

				$slugField = config('pages.' . $data['section'] . '.slug');

				//generate slug from english version of field
				$slug = $page->createSlug($data['items'][0]['fields'][$slugField]['value']);

				$page->slug = $slug;
				$page->save();
			}
		}

		$landingPageFieldRepository->createFields($page->id, $data);

		if(!empty($data['coverToken'])) {
			File::whereToken($data['coverToken'])
				->update(['parent_id' => $page->id]);
		}
	}

	public function destroy($id)
	{
		LandingPage::destroy($id);
		//todo remove files if needed
	}


	/*
	|--------------------------------------------------------------------------
	| HELPER FUNCTIONS
	|--------------------------------------------------------------------------
	*/

	/**
	 * Helper method for update by page token
	 * @param       $token
	 * @param       $page
	 * @param array $images
	 */
	private function additionalUpdate($token, $page, $images = [])
	{
		switch($token) {
			case 'home' :
				//save files parent_id
//				FileRepository::updateFilesParentId($page->id, File::FILE_HOME_PARTNER,  $images);
				break;
		}

	}

	/**
	 * Get additional info about page by token
	 * @param $token
	 * @param $response
	 * @param $page
	 */
	private function additionalShow($token, &$response, $page)
	{
		switch($token) {
			case 'home' :
				$images = FileRepository::getByParentId($page->id, File::FILE_HOME_SLIDER);
				break;
		}

		if(isset($images)) {
			$response['images'] = FileRepository::transformWithDimensionUrls($images);
		}
	}

	/**
	 * @param $parentToken
	 * @param $section
	 * @param $items
	 */
	private function additionalShowBySection($parentToken, $section, &$items)
	{
		foreach($items as $item) {
			if($parentToken == 'home' && $section == 'slider') {
				$item->images = FileRepository::getByParentId($item->id, File::FILE_HOME_SLIDER);
			}
		}
	}

}
