<?php namespace App;

class Message extends ModelSetup
{

	public function users() {

		return $this->belongsToMany(User::class)->withPivot(['status']);
	}
}
