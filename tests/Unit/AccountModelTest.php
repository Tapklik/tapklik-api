<?php namespace Tests\Unit;

use App\Account;
use App\AdvertiserDomain;
use App\Campaign;
use App\Exchange;
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
}
