<?php namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Response\FractalResponse;
use App\Message;
use App\Packages\Courier\Drivers\OneadDriver;
use App\Transformers\MessageTransformer;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
	public function index()
	{

	}

	public function store()
	{
		$onead = new OneadDriver(request('config'));

		$messageId = $onead->publish();
		$message = Message::with(['users'])->where(['id' => $messageId])->firstOrFail();

		return $this->item($message, new MessageTransformer);
	}
}
