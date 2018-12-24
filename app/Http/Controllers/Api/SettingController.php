<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerTraits\ApiTrait;
use App\Repositories\SettingRepository;
use App\Setting;
use App\Http\Requests;

//use App\Http\Requests\StoreFaqRequest;
use App\Transformers\SettingTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

/**
 * Class FaqController
 *
 * @package App\Http\Controllers\Api
 */
class SettingController extends Controller {

	use ApiTrait;
	/**
	 * @var
	 */
	protected $transformer;

	/**
	 * @param $transformer
	 */
	function __construct(SettingTransformer $transformer)
	{
		$this->transformer = $transformer;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$items =  Setting::all();


		return $this->respond(
			[
				'data' => $this->transformer->transformCollection($items->toArray())
			]
		);

	}

//	/**
//	 * Show the form for creating a new resource.
//	 *
//	 * @return Response
//	 */
//	public function create()
//	{
//		//
//	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param StoreFaqRequest|Request $request
	 *
	 * @return Response
	 */
//	public function store(StoreFaqRequest $request)
//	{
//		Faq::create(Input::all());
//	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
//	public function show($id)
//	{
//		$faq = Faq::find($id);
//
//		if(! $faq) {
//			return $this->respondNotFound('Faq does not exists');
//		}
//
//		return $this->respond([
//			'data' => $this->transformer->transform($faq->toArray())
//		]);
//	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
//	public function update($id, StoreFaqRequest $request)
//	{
//		Faq::find($id)->update($request->all());
//	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 * @internal param int $id
	 */
//	public function destroy($id)
//	{
//		Faq::destroy($id);
//	}

	//Actions for group managing

	// Massive update of All settings
	public function updateAll(Request $request)
	{
		SettingRepository::updateAll($request->all());
	}
}
