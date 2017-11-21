<?php namespace Tests\Unit;

use App\Account;
use App\Transformers\AccountTransformer;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountModelTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function it_has_users_relationship()
    {

        $account = factory(Account::class)->make();

        $this->assertInstanceOf(HasMany::class, $account->users());
    }

    /** @test */
    public function transformer_returns_proper_keys()
    {

        $account = factory(Account::class)->make();

        $expected = $this->item($account, new AccountTransformer);

        $this->assertArrayHasKey('billing', $expected['data']);
        $this->assertArrayHasKey('address', $expected['data']['billing']);
        $this->assertArrayHasKey('company', $expected['data']['billing']);
        $this->assertArrayHasKey('email', $expected['data']['billing']);
        $this->assertArrayHasKey('country', $expected['data']['billing']);
        $this->assertArrayHasKey('city', $expected['data']['billing']);
    }
}
