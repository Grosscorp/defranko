<?php namespace App\Http\Controllers;

use App\Http\Controllers\ControllerTraits\ApiTrait;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\FileRepository;
use Illuminate\Http\Request;

/**
 * Class ConfigController
 *
 * @package App\Http\Controllers
 */
class ConfigController extends Controller
{
	use ApiTrait;
	/**
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index()
	{
		$files = config('files');

		$files['sizes'] = FileRepository::getAllSizes();

		return $this->respond([
			'ENV' => app()->environment(),
			'files' => $files,
			'CSRF_TOKEN' => csrf_token(),
			'langs' => config('langs'),
			'pages' => config('pages'),
			'storage_url'  => env('STORAGE_URL'),
		]);
	}
}
