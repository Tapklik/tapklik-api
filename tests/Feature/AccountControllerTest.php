<?php
use App\Account;
use App\Transformers\AccountTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {

        parent::setUp();

        $this->account = factory(Account::class)->create();
    }

    /** @test */
    public function user_can_list_accounts()
    {

        $this->get('/v1/accounts')->assertStatus(Response::HTTP_OK)->assertExactJson(
                $this->collection(Account::all(), new AccountTransformer)
            );
    }

    /** @test */
    public function it_user_can_list_account_data()
    {

        $this->get('/v1/accounts/'.$this->account->uuid)->assertStatus(Response::HTTP_OK)->assertExactJson(

                $this->item($this->account, new AccountTransformer)
            );
    }

    /** @test */
    public function user_can_create_an_account()
    {

        $account = factory(Account::class)->make();

        $this->post('/v1/accounts', $account->toArray())->assertStatus(Response::HTTP_OK)->assertExactJson(
                $this->item(Account::orderBy('id', 'desc')->first(), new AccountTransformer)
            );
    }

    /** @test */
    public function user_can_access_users_accounts_endpoint()
    {

        $this->get('/v1/accounts/'.$this->account->uuid.'/users')->assertStatus(Response::HTTP_OK)->assertExactJson(
                $this->collection($this->account->users, new UserTransformer)
            );
    }

    /** @test */
    public function user_can_create_a_user()
    {

        $user = factory(\App\User::class)->make();

        $this->post('/v1/accounts/'.$this->account->uuid.'/users', $user->toArray())->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas(
            'users',
            [
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'email'      => $user->email,
            ]
        );
    }
}
