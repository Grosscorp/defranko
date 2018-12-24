<?php

namespace App\Http\Controllers;

use App\Events\NewMessageFromContactPage;
//use App\Repositories\CommentRepository;
//use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class __SAMPLE__ServicesController extends Controller
{
	public function storeContact(Request $request)
	{
		$this->validate($request, [
				'name' => 'required',
				'email' => 'email|required',
				'message' => 'required'
		]);

		\Event::fire(new NewMessageFromContactPage($request->all()));

		return response()->json(['message' => 'Message was sent']);
	}

//	public function storeComment(Request $request, CommentRepository $commentRepository)
//	{
//		$this->validate($request, [
//			'item_id' => 'required|integer',
//			'item_type' => 'required|integer',
//			'name' => 'required|max:128',
//			'email' => 'required|email|max:128',
//			'comment' => 'required|max:5000',
//			'captcha' => 'required|captcha'
//		]);
//
//		$data = $request->all();
//
//		$comment = $commentRepository->createComment($data);
//
//		return response()->json([
//			'html' =>  (string)view('pages.partials.commenting.one-comment', compact('comment'))
//		]);
//	}




//	public function storeSubscription(Request $request)
//	{
//		$this->validate($request, [
//			'email' => 'email|required|unique:subscriptions'
//		]);
//
//		$email = $request->get('email');
//
//		if(! Subscription::where('email', $email)->exists()) {
//			Subscription::create([
//				'email' => $email
//			]);
//		}
//	}

	public function captcha()
	{
		return captcha('mini');
	}
}
