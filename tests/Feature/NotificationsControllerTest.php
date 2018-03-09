<?php


	use App\Campaign;
	use App\Transformers\AdvertiserDomainTransformer;
	use Illuminate\Http\Response;
	use Tests\TestCase;
	use Illuminate\Foundation\Testing\DatabaseMigrations;
	use Illuminate\Foundation\Testing\WithoutMiddleware;

	class NotificationsControllerTest extends TestCase
	{

		use DatabaseMigrations, WithoutMiddleware;

		/** @test */
		public function it_can_retrieve_user_messages()
		{
			$user = factory(\App\User::class)->create();
			$messages = factory(\App\Message::class, 20)->create();

			$messages->each(function ($message) use ($user) {
				$user->messages()->save($message);
			});

			$result = $this->get('v1/core/notifications/' . $user->id);

			$result->assertStatus(Response::HTTP_OK);

			$data = $result->decodeResponseJson();

			$this->assertCount(20, $data['data']);
		}

		/** @test */
		public function it_can_update_status()
		{
			$user = factory(\App\User::class)->create();
			$message = factory(\App\Message::class)->make();

			$user->messages()->save($message);

			$result = $this->put('v1/core/notifications/' . $message->id, ['status' => 1]);

			$result->assertStatus(Response::HTTP_OK);

			$result->assertExactJson([
				'error' => false,
				'message' => 'Message updated successfully'
			]);
		}
	}
