<?php namespace App\Packages\Courier\Drivers;

use App\Packages\Courier\Contracts\AbstractService;

class OneadDriver extends AbstractService
{
	public function publish(): bool
	{
		// Send message to all the users
		$this->config->getUsers()->each( function ($user) {
			return Mail::send($user->email, $this->config->getMessage());
		});
	}
}