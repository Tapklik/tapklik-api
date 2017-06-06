<?php

use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthenticateControllerTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function user_can_login()
    {
        $account = factory(\App\Account::class)->create();
        $user = factory(\App\User::class)->create([
            'account_id' => $account->id,
            'password'   => bcrypt('secret')
        ]);

        $page = $this->post('/v1/auth', [
            'email'    => $user->email,
            'password' => 'secret',
        ])
        ->assertStatus(Response::HTTP_OK);


        $auth  = base64_decode($page->decodeResponseJson()['token']);
        $token = (new \Lcobucci\JWT\Parser())->parse((string)$auth);

        $this->assertEquals($user->name, $token->getClaim('name'));
        $this->assertEquals($user->email, $token->getClaim('email'));
        $this->assertEquals($user->uuid, $token->getClaim('uuid'));
        $this->assertEquals($account->id, $token->getClaim('id'));
        $this->assertEquals($user->account_id, $token->getClaim('accountId'));
    }

    /** @test */
    public function user_should_get_a_forbidden_error_when_trying_to_login_with_wrong_user_pass()
    {
        $this->post('/v1/auth', ['email' => 'test@test.com', 'password' => 'password'])
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertExactJson([
                'error' => [
                    'code'    => Response::HTTP_UNAUTHORIZED,
                    'details' => 'Wrong username / password',
                    'message' => 'Unauthorized',
                    'request' => ''
                ]
            ]);
    }
}
