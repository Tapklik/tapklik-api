<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersTest extends TestCase {
    use DatabaseMigrations, WithoutMiddleware;

    /** @test */
    public function it_can_delete_a_user() 
    {
        $account = factory(\App\Account::class)->create();
        $user = factory(App\User::class)->make();

        $account->users()->save($user);

        $this->assertDatabaseHas('users', ['email' => $user->email]);

        $this->json('delete', '/v1/accounts/' . $account->uuid . '/users/' . $user->uuid)
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('users', ['email' => $user->email]);

    }
}
