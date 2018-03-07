<?php namespace Tests\Unit;

use App\Packages\Courier\Drivers\OneadDriver;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CourierOneadDriverTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function it_can_create_a_message() {

		$user = factory(User::class)->create();

		$config = [
			'service'    => ['onead'],
			'message'    => 'test message',
			'users'      => [$user->id],
			'created_at' => (string) time()
		];

		$onead = new OneadDriver($config);
		$this->assertInternalType('integer', $onead->publish());

		$this->assertCount(1, $onead->getForUserId($user->id));
	}
}
