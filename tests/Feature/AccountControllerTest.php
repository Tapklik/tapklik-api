<?php
use App\Account;
use App\Transformers\AccountTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AccountControllerTest extends TestCase {

    use DatabaseMigrations, WithoutMiddleware;

    public function setUp()
    {

        parent::setUp();

        $this->account = factory(Account::class)->create();
    }

    /** @test */
    public function user_can_list_accounts()
    {

        $this->get('/v1/accounts', [
            'Authorize' => 'Bearer ' . $this->generateApiToken($this->account->id)
        ])
        ->assertStatus(Response::HTTP_OK)
        ->assertExactJson(
            $this->collection(Account::all(), new AccountTransformer)
        );
    }

    /** @test */
    public function it_user_can_list_account_data()
    {

        $this->get('/v1/accounts/' . $this->account->uuid)
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(

                $this->item($this->account, new AccountTransformer)
            );
    }

    /** @test */
    public function user_can_create_an_account()
    {
        $account = factory(Account::class)->make();

        $this->post('/v1/accounts', $account->toArray())
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                $this->item(Account::orderBy('id', 'desc')->first(), new AccountTransformer)
            );
    }

    /** @test */
    public function user_can_access_users_accounts_endpoint()
    {
        $this->get('/v1/accounts/' . $this->account->uuid . '/users')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                $this->collection($this->account->users, new UserTransformer)
            );
    }

    /** @test */
    public function user_can_create_a_user()
    {
        $user = factory(\App\User::class)->make(['status' => 1]);

        $this->post('/v1/accounts/' . $this->account->uuid . '/users', $user->toArray())
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                $this->item($this->account->users->last(), new UserTransformer)
            );

        $this->assertDatabaseHas(
            'users',
            [
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'email'      => $user->email,
            ]
        );
    }

    /** @test */
    public function user_can_access_user_details_account_endpoint()
    {
        $user = factory(\App\User::class)->create(['account_id' => $this->account->id]);

        $this->get('/v1/accounts/' . $this->account->uuid . '/users/' . $user->uuid)
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                $this->item($user, new UserTransformer)
            );
    }

    /** @test */
    public function user_can_update_account()
    {
        $account = factory(Account::class)->create();

        $result = $this->put('/v1/accounts/' . $account->uuid, [
            'name' => 'Legend'
        ])->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('accounts', ['id' => $account->id, 'name' => 'Legend']);
    }

    /** @test */
    public function user_data_can_be_updated()
    {
        $campaign = factory(\App\Campaign::class)->create();

        $user = factory(\App\User::class)->create(['first_name' => 'rok', 'account_id' => $campaign->account->id]);


        $this->assertDatabaseHas('users', ['first_name' => 'rok', 'id' => $user->id]);

        $result = $this->put(
            'v1/accounts/'.$campaign->account->uuid.'/users/'.$user->uuid,
            ['first_name' => 'halid']
        )->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('users', ['first_name' => 'halid', 'id' => $user->id]);

        $result->assertExactJson([
            'data' => [
                'id'         => $user->uuid,
                'first_name' => 'halid',
                'last_name'  => $user->last_name,
                'name'       => 'halid ' . $user->last_name,
                'email'      => $user->email,
                'phone'      => $user->phone,
                'status'     => $user->status
            ]
        ]);
    }
}
