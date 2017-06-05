<?php
use App\Account;
use App\Transformers\AccountTransformer;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountControllerTest extends TestCase {

    use DatabaseMigrations;

    public function setUp()
    {

        parent::setUp();

        $this->account = factory(Account::class)->create();
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
}
