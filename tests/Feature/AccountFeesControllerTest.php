<?php
use App\Account;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AccountFeesControllerTest extends TestCase {

    use DatabaseMigrations, WithoutMiddleware;

    public function setUp()
    {

        parent::setUp();

        $this->account = factory(Account::class)->create();
    }

    /** @test */
    public function it_can_update_fees()
    {
        $account = factory(Account::class)->create();

        $response = $this->put('v1/accounts/' . $account->uuid . '/fees', [
            'fee_fixed' => 10,
            'fee_variable' => 20
        ])->assertStatus(Response::HTTP_OK);

        $data = $response->decodeResponseJson();

        $this->assertEquals(10, $data['data']['fees']['fixed']);
        $this->assertEquals(20, $data['data']['fees']['variable']);
    }
}
