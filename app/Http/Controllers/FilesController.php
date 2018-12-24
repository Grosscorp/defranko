<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\FileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * Class FilesController
 *
 * @package App\Http\Controllers
 */
class FilesController extends Controller {

	/**
	 * @param                $token
	 * @param FileRepository $fileRepository
	 *
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function download($token, FileRepository $fileRepository)
	{
		$file = $fileRepository->getByToken($token);
		$path = $fileRepository->generateDownloadLink($file);

		return \Response::download($path, $file->name, [
			'Content-Length: '. $file->size
		]);

	}
}