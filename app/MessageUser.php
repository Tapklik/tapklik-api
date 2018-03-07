<?php namespace App;


class MessageUser extends ModelSetup
{

	public function user()
	{

		return $this->belongsTo(User::class);
	}

	public function message()
	{
		return $this->belongsTo(Message::class);
	}
}
