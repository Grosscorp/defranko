<?php namespace App\Http\Controllers;

use App\Events\NewMessageFromContactPage;
use App\Http\Requests;

use App\Repositories\LandingPageRepository;
use App\Repositories\SettingRepository;
use App\Traits\PageSeo;

class PagesController extends Controller {
	use PageSeo;
	/**
	 * @var LandingPageRepository
	 */
	private $landingPageRepository;


	/**
	 * PagesController constructor.
	 *
	 * @param LandingPageRepository $landingPageRepository
	 * @param SettingRepository     $settingRepository
	 */
	public function __construct(LandingPageRepository $landingPageRepository, SettingRepository $settingRepository)
	{
		parent::__construct();
		$this->landingPageRepository = $landingPageRepository;
		$this->settings = $settingRepository->prepareAll();

	}

	/*
	|--------------------------------------------------------------------------
	| SAMPLE DATA
	|--------------------------------------------------------------------------
	*/

//	public function home()
//	{
//		$page = $this->landingPageRepository->getByToken('home');
//		if(!$page) abort(404);
//
//		$fields = $this->landingPageRepository->transformPage($page);
//		$files = $page->files;
//
//
//		$seo_title = $this->getSeoAttributeFromFields($fields, 'seo_title');
//		$seo_description = $this->getSeoAttributeFromFields($fields, 'seo_description');
//
//
//		$sliderCollection = $this->landingPageRepository->getByTokenAndSection('home', 'home_slider');
//		$sliderItems = $this->landingPageRepository->getFullInfoFromCollectionOfPages($sliderCollection->toArray());
//
//		$settings = $this->settings;
//
//		$fields['video_id'] = false;
//
//		if(isset($fields['video_url'])) {
//			$fields['video_id'] = $this->get_youtube_video_id($fields['video_url']);
//		}
//
//		return view('pages/home', compact('fields', 'files', 'sliderItems') + compact('seo_title', 'seo_description', 'settings'));
//	}

//	public function about()
//	{
//		$page = $this->landingPageRepository->getByToken('about');
//		if(!$page) abort(404);
//		$fields = $this->landingPageRepository->transformPage($page);
//
//		$seo_title = $this->getSeoAttributeFromFields($fields, 'seo_title');
//		$seo_description = $this->getSeoAttributeFromFields($fields, 'seo_description');
//
//		$teamCollection = $this->landingPageRepository->getByTokenAndSection('about', 'about_team');
//		$teamItems = $this->landingPageRepository->getFullInfoFromCollectionOfPages($teamCollection->toArray());
//
//		$settings = $this->settings;
//
//		return view('pages/about', compact('fields', 'teamItems') + compact('seo_title', 'seo_description', 'settings'));
//	}

//	public function content()
//	{
//		$page = $this->landingPageRepository->getByToken('content');
//		if(!$page) abort(404);
//		$fields = $this->landingPageRepository->transformPage($page);
//
//		$seo_title = $this->getSeoAttributeFromFields($fields, 'seo_title');
//		$seo_description = $this->getSeoAttributeFromFields($fields, 'seo_description');
//
//		$settings = $this->settings;
//
//
//		$fields['video_id'] = false;
//
//		if(isset($fields['video_url'])) {
//			$fields['video_id'] = $this->get_youtube_video_id($fields['video_url']);
//		}
//
////		dd($fields);
//
//		return view('pages/content', compact('fields') + compact('seo_title', 'seo_description', 'settings'));
//	}

//	public function technology()
//	{
//		$page = $this->landingPageRepository->getByToken('technology');
//		if(!$page) abort(404);
//		$fields = $this->landingPageRepository->transformPage($page);
//
//		$seo_title = $this->getSeoAttributeFromFields($fields, 'seo_title');
//		$seo_description = $this->getSeoAttributeFromFields($fields, 'seo_description');
//
//		$faqCollection = $this->landingPageRepository->getByTokenAndSection('technology', 'technology_faq');
//		$faqItems = $this->landingPageRepository->getFullInfoFromCollectionOfPages($faqCollection->toArray());
//
//		$faqs = json_encode($faqItems);
//
//		$settings = $this->settings;
//
//		return view('pages/technology', compact('fields', 'faqs') + compact('seo_title', 'seo_description', 'settings'));
//	}

//	public function contact()
//	{
//		$page = $this->landingPageRepository->getByToken('contact');
//		if(!$page) abort(404);
//		$fields = $this->landingPageRepository->transformPage($page);
//
//		$seo_title = $this->getSeoAttributeFromFields($fields, 'seo_title');
//		$seo_description = $this->getSeoAttributeFromFields($fields, 'seo_description');
//
//		$settings = $this->settings;
//
//		$contactTopText = !empty($fields['contact_top_text']) ? $fields['contact_top_text'] : false;
//
//		return view('pages/contact', compact('contactTopText','seo_title', 'seo_description', 'settings'));
//	}


//	private function get_youtube_video_id($url)
//	{
//		preg_match(
//			'/[\\?\\&]v=([^\\?\\&]+)/',
//			$url,
//			$matches
//		);
//
//		if(isset($matches[1])) {
//			return $matches[1];
//		}
//
//		return false;
//	}

//	public function index(Request $request)
//	{
//		if($page = $request->get('page')) {
//			return view('pages/' . $page);
//		}
//
//		$params = [];
//
//		if(\Session::has('apply_success')) {
//			$params['apply_success'] = \Session::get('apply_success');
//		}
//		if(\Session::has('contact_success')) {
//			$params['contact_success'] = \Session::get('contact_success');
//		}
//
//		return view('pages/dummy', $params);
//	}

//	public function comingSoon()
//	{
//		return view('pages/dummy');
//	}

//	public function contact(Request $request)
//	{
////		dd($request->all());
//
//		$this->validate($request, [
//			'first_name' => 'required',
//			'last_name' => 'required',
//			'email' => 'required|email',
//			'subject' => 'required',
//			'text' => 'required',
//		]);
//
//		\Mail::send('emails/contact', ['data' => $request->all()], function($message)
//		{
//			$message->to('kolodiy.dev@gmail.com', '')->subject('Contact form inquiry');
//		});
//
//		\Session::flash('contact_success', 'Contact shit has been sent');
//
//		return redirect()->back();
//
//	}
}
