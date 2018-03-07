<?php namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Response\FractalResponse;
use App\Message;
use App\Packages\Courier\Drivers\OneadDriver;
use App\Transformers\MessageTransformer;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotificationsController extends Controller
{
	public function index($id)
	{
		try {
			$user = User::find($id);

			return $this->collection($user->messages, new MessageTransformer);
		} catch (ModelNotFoundException $e) {

			return response([
				'error' => true,
				'message' => 'User not found'
			], Response::HTTP_NOT_FOUND);
		}
	}

	public function store()
	{
		$onead = new OneadDriver(request('config'));

		$messageId = $onead->publish();
		$message = Message::with(['users'])->where(['id' => $messageId])->firstOrFail();

		return $this->item($message, new MessageTransformer);
	}
}
