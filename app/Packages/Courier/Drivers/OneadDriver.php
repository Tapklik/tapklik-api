<?php namespace App\Packages\Courier\Drivers;

use App\Message;
use App\Packages\Courier\Contracts\AbstractService;
use App\Packages\Courier\Contracts\RetrievableInterface;
use App\Transformers\MessageTransformer;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OneadDriver extends AbstractService implements RetrievableInterface
{
	public function publish(): int
	{
		$message = Message::create([
			'message'    => $this->config->getMessage(),
			'created_at' => $this->config->getTimestamp()
		]);

		// Send message to all the users
		$users = collect($this->config->getUsers());
		$users->each(function ($user) use ($message) {
			try {
				$user = User::find($user);
				$user->messages()->save($message);
			} catch (ModelNotFoundException $e) {}
		});

		return $message->id;
	}

	public function getForUserId(int $id)
	{
		try {
			$user = User::find($id);

			return $user->messages;
		} catch (ModelNotFoundException $e) {

		}
	}

	public function getForUserUuId(string $uuid)
	{
		try {
			$user = User::findByUuId($uuid);

			return $user->messages;
		} catch (ModelNotFoundException $e) {

		}
	}
}