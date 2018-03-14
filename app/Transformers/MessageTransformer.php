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
			'status'     => $notification->users->first()->pivot->status,
			'created_at' => $notification->created_at->toDateTimeString()
		];
	}
}
