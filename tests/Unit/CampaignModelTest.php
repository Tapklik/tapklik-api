<?php
use App\Campaign;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CampaignModelTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {

        parent::setUp();

        $this->campaign = factory(Campaign::class)->create();
    }

    /** @test */
    public function it_has_exchanges_relationship()
    {

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\HasMany::class, $this->campaign->exchanges());
    }

    /** @test */
    public function it_has_advertiser_domains_relationship()
    {

        $this->assertInstanceOf(
            Illuminate\Database\Eloquent\Relations\HasMany::class,
            $this->campaign->advertiserDomains()
        );
    }

    /** @test */
    public function it_has_categories_relationship()
    {

        $this->assertInstanceOf(
            Illuminate\Database\Eloquent\Relations\BelongsToMany::class,
            $this->campaign->categories()
        );
    }

    /** @test */
    public function it_has_budget_relationship()
    {

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\HasOne::class, $this->campaign->budget());
    }

    /** @test */
    public function it_has_demography_relationship()
    {

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\HasOne::class, $this->campaign->demography());
    }

    /** @test */
    public function it_has_creatives_relationship()
    {

        $this->assertInstanceOf(
            Illuminate\Database\Eloquent\Relations\BelongsToMany::class,
            $this->campaign->creatives()
        );
    }

    /** @test */
    public function it_has_geographies_relationship()
    {

        $this->assertInstanceOf(
            Illuminate\Database\Eloquent\Relations\BelongsToMany::class,
            $this->campaign->geography()
        );
    }

    /** @test */
    public function it_has_account_relationship()
    {

        $this->assertInstanceOf(
            Illuminate\Database\Eloquent\Relations\HasOne::class,
            $this->campaign->account()
        );
    }

    /** @test */
    public function it_can_retrieve_campaigns_limited_to_user_account()
    {

        $account   = factory(\App\Account::class)->create();
        $user      = factory(\App\User::class)->create(['account_id' => $account->id]);
        $campaigns = factory(Campaign::class, 5)->create(['account_id' => $account->id]);

        $token = \App\User::apiToken($user);

        $page = $this->get(
            '/v1/campaigns',
            [
                'Authorization' => 'Bearer '. $token,
            ]
        )->assertStatus(Response::HTTP_OK);

        $response = $page->decodeResponseJson();

        $this->assertCount(5, $response['data']);
    }
}
