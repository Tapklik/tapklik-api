<?php namespace App;


class MessageUser extends ModelSetup
{
	protected $table      = 'message_user';
	public    $timestamps = false;

	public function user()
	{

		return $this->belongsTo(User::class);
	}

	public function message()
	{
		return $this->belongsTo(Message::class);
	}
}
