<?php namespace App\Http\Controllers\Api\Common;

use App\File;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerTraits\ApiTrait;
use App\Http\Requests;

use App\Repositories\FileRepository;
use App\Services\Image;
use App\Traits\FileDimensions;
use Illuminate\Http\Request;
use Input;

class FilesController extends Controller {
	use FileDimensions, ApiTrait;
	/**
	 * @param Image $Image
	 *
	 * @return mixed
	 */
	public function store(Image $Image, Request $request)
	{
		$data = $request->all();

		$type = $data['type'];
		$file = isset($data['file']) ? $data['file'] : null;
		$pid = isset($data['pid']) ? $data['pid'] : null; // TODO WTF

		$preview_size = isset($data['preview_size']) ? $data['preview_size'] : 'tiny';
		$preview_ext =  isset($data['preview_ext']) ? $data['preview_ext'] : 'jpg';

		$token = strtolower(str_random(8));

		$rules = \Config::get('files.rules');
		// TODO check extensions in rules

		$pid = isset($data['parent_id']) && \Auth::check() ? $data['parent_id'] : null; // TODO WTF

		if($file) {
			$isImage = $this->checkIfImage($file->getClientOriginalExtension());

			if(isset($rules[$type]['isImage']) && $rules[$type]['isImage'] == false) {
				$isImage = false;
			}

			// Upload & resize
			$upload = $Image->upload($file, $type, $token, $isImage);

			if(!$upload) {
				return $this->respond([
						'message' => 'Cannot upload file. Please try again.'
				])->setStatusCode(422);
			}


			if (count($upload)) {

				// Remove old file if RULE===true
				if(isset($rules[$type]) && $rules[$type]['single']) {
					File::where('parent_id', $pid)->where('type', $type)->where('user_id', \Auth::id() ?: null)->update(['parent_id' => 0]);
				}

				$fileData = File::create(array(
						'type' => $type,
						'parent_id' => $pid,
						'user_id' => \Auth::id() ?: null,
						'name' => $file->getClientOriginalName(),
						'size' => $file->getClientSize(),
						'ext' => $file->getClientOriginalExtension(),
						'isImage' => $isImage,
						'token' => $token
				));

				if($isImage) {
					//uncomment if neeeded
//					$fileData->dimensions = $this->getImageDimensions($fileData);
					$fileData->save();
				}

				$response = $fileData->toArray();
				$response['url'] = FileRepository::getUrl($fileData, $preview_size, $preview_ext);

				return $this->respond( $response );
			}
		}


//		return $response;

		return $this->respond([
				'message' => 'Error upload file. No file.'
		])->setStatusCode(407);
	}

	private function checkIfImage($ext)
	{
		return (in_array(strtolower($ext), array('jpg', 'png', 'jpeg', 'bmp', 'gif')) ? 1 : 0);
	}

	/**
	 * Delete from DB and storage.
	 *
	 * @param $token
	 * @param FileRepository $fileRepository
	 * @return mixed
	 * @internal param $fileId
	 */
	public function forceDelete($token, FileRepository $fileRepository)
	{
		try {
			$file = File::where('token', $token)->first();

			// Check if owner || admin
			if($file->sender_id === \Auth::id() || \Auth::user()->isAdmin() ) {
				$fileRepository->deleteFile($file);
			}

		} catch (\Exception $e) {
			return $this->respondWithError(['message' => $e->getMessage()]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$file = File::find($id);
		if($file->user_id === \Auth::id() || \Auth::user()->isAdmin() ) {
			$file->update(['parent_id'=>0]);

			return $this->respond([
			    'success' => true
			]);
		}
	}
}
