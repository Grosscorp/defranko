<?php namespace App\Http\Controllers\Api;

use App\File;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerTraits\ApiTrait;
use App\Http\Requests;
use App\Http\Requests\StoreLandingPageItemRequest;
use App\LandingPageItem;
use App\Repositories\FileRepository;


class LandingPageItemsController extends Controller {

	use ApiTrait;

	public function listByParent($parentId, LandingPageItem $landingPageItem)
	{
		return $landingPageItem->getByParentId($parentId);
	}

	/**
	 * @param StoreLandingPageItemRequest $request
	 */
	public function store(StoreLandingPageItemRequest $request)
	{
		$data = $request->all();
		$item = LandingPageItem::create($data);

		if(!empty($data['coverToken'])) {
			File::whereToken($data['coverToken'])
				->update(['parent_id' => $item->id]);
		}

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return $this->respond(LandingPageItem::find($id)->toArray());
	}

	/**
	 * @param                             $id
	 * @param StoreLandingPageItemRequest $request
	 */
	public function update($id, StoreLandingPageItemRequest $request)
	{
		$data = $request->all();
		$item = LandingPageItem::find($id);

		if(
			(!empty($data['coverToken']) || ($item->coverToken && empty($data['coverToken']))) //cover was added or removed
			&& $data['coverToken'] != $item->coverToken
		) {
			FileRepository::setParentIdByToken($data['coverToken'], $item->id);
			FileRepository::setParentIdByToken($item->coverToken, null);
		}

		$item->update($data);


	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		LandingPageItem::destroy($id);

		//todo: remove cover file by token if exists
	}

}
