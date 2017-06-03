<?php
use App\Campaign;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CampaignModelTest extends TestCase {

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
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\HasMany::class, $this->campaign->advertiserDomains());
    }

    /** @test */
    public function it_has_categories_relationship()
    {
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $this->campaign->categories());
    }

    /** @test */
    public function it_has_budget_relationship()
    {
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\HasOne::class, $this->campaign->budget());
    }
}
