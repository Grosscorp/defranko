<?php namespace App\Http\Controllers\Api\Common;

use App\File;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerTraits\ApiTrait;
use App\Http\Requests;
use App\Http\Requests\ContactFormRequest;
use App\LandingPage;
use App\LandingPageItem;
use App\Repositories\FileRepository;
use App\Repositories\LandingPageItemRepository;
use App\Repositories\LandingPageRepository;
use App\Repositories\SettingRepository;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PagesController extends Controller {

	use ApiTrait;

	/**
	 * @var LandingPageRepository
	 */
	private $landingPageRepository;

	/**
	 * @param LandingPageRepository $landingPageRepository
	 */
	function __construct(LandingPageRepository $landingPageRepository)
	{
		parent::__construct();
		$this->landingPageRepository = $landingPageRepository;
	}

	public function home()
	{
		$page = $this->landingPageRepository->getByToken('home', $this->getLang());
		$sliderRaw = $this->landingPageRepository->getByParentId($page->id, $this->getLang());

		$slider = $this->prepareSliderInfo($sliderRaw);

//		$images = FileRepository::getByParentId($page->id, File::FILE_HOME_PARTNER);
//		$images = FileRepository::transformWithDimensionUrls($images);

		$page = $this->landingPageRepository->transformPage($page);

		return $this->respond(compact('page', 'slider'));
	}

	/*
	 * About page
	 */
	public function about()
	{
		$page = LandingPage::getByToken('about-us');
		$members = LandingPageItem::whereParentIdAndSection($page->id, 'team')->get();

		$page = LandingPage::transformPage($page);
		return $this->respond(compact('page', 'members'));
	}


	/**
	 * Request a quote page
	 */
	public function requestQuote()
	{
		$page = LandingPage::getByToken('request-quote');
		$page = LandingPage::transformPage($page);

		return $this->respond(compact('page'));
	}

	/**
	 * What we do page
	 */
	public function whatWeDo()
	{
		$page = LandingPage::getByToken('what-we-do');
		$page = LandingPage::transformPage($page);

		return $this->respond(compact('page'));
	}

	/**
	 * What we do page
	 */
	public function terms()
	{
		$page = LandingPage::getByToken('terms');
		$page = LandingPage::transformPage($page);

		return $this->respond(compact('page'));
	}

	/**
	 * Fleet page
	 */
	public function fleet()
	{
		$page = LandingPage::getByToken('fleet');
		$page = LandingPage::transformPage($page);

		return $this->respond(compact('page'));
	}

	/**
	 * How it works page
	 */
	public function howItWorks()
	{
		$page = LandingPage::getByToken('how-it-works');
		$parentId = $page->id;

		$page = LandingPage::transformPage($page);

		$steps = LandingPageItem::getByParentId($parentId);
		//prepare token based Array for view
		$steps = LandingPageItemRepository::prepareWithToken($steps);

		return $this->respond(compact('page', 'steps'));
	}

	/**
	 * Faq page
	 */
	public function faq()
	{
		$page = LandingPage::getByToken('faq');

		$faqs = LandingPageItem::whereParentIdAndSection($page->id, 'faq')->get();

		$page = LandingPage::transformPage($page);

		return $this->respond(compact('page', 'faqs'));
	}

	public function careers()
	{
		$page = LandingPage::getByToken('careers');

		$careers = LandingPageItem::whereParentIdAndSection($page->id, 'careers')->get();

		$page = LandingPage::transformPage($page);

		return $this->respond(compact('page', 'careers'));
	}

	/**
	 * Contact page
	 */
	public function contact()
	{
		$settings = SettingRepository::prepareAll();
		$page = LandingPage::getByToken('contact');
		$page = LandingPage::transformPage($page);

		return $this->respond(compact('page', 'settings'));
	}

	public function sendContactMessage(ContactFormRequest $request)
	{
		\Mail::send('emails.contact', $request->all(), function($message)
		{
			$message->to(SettingRepository::prepareAll()['email'], 'Admin ')
				->subject('Message from contact page');
		});
	}

	/**
	 * Parse data for slider
	 * @param $sliderRaw
	 *
	 * @return array
	 */
	private function prepareSliderInfo($sliderRaw)
	{
		$data = [];

		foreach($sliderRaw as $item) {
			if($item->coverToken) {
				$info = $this->landingPageRepository->transformPage($item);
				$info['coverToken'] = $item->coverToken;

				$data[] = $info;
			}
		}
		return $data;
	}

}
