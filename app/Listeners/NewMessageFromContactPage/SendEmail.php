<?php

namespace App\Listeners\NewMessageFromContactPage;

use App\Events\NewMessageFromContactPage;
use App\Repositories\SettingRepository;
use App\Services\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail implements ShouldQueue
{
	/**
	 * @var Notification
	 */
	private $notification;
	/**
	 * @var SettingRepository
	 */
	private $settingRepository;

	/**
	 * Create the event listener.
	 *
	 * @param Notification      $notification
	 * @param SettingRepository $settingRepository
	 */
	public function __construct(Notification $notification, SettingRepository $settingRepository)
	{
		$this->notification = $notification;
		$this->settingRepository = $settingRepository;
	}

	/**
	 * Handle the event.
	 *
	 * @param  NewMessageFromContactPage $event
	 * @return void
	 */
	public function handle(NewMessageFromContactPage $event)
	{
		$data = $event->data;
		$settings = $this->settingRepository->prepareAll();

		if($settings['email']) {
			$this->notification->send('emails/NewMessageFromContactPage', $settings['email'],
				'New message from contact page',
				compact('data'), true);
		}
	}
}
