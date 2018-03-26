<?php namespace App\Transformers;

use App\Message;
use League\Fractal\TransformerAbstract;

class MessageTransformer extends TransformerAbstract
{

	public function transform(Message $notification)
	{

		return [
			'id'         => $notification->id,
			'message'    => $notification->message,
			'status'     => isset($notification->pivot->status) ? $notification->pivot->status : 0,
			'created_at' => $notification->created_at->toDateTimeString()
		];
	}
}
