<?php
use App\Transformers\BudgetTransformer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BudgetControllerTest extends TestCase {

    use DatabaseMigrations;

    /**
     *
     */
    public function setUp()
    {

        parent::setUp();

        $this->campaign = factory(\App\Campaign::class)->create();

    }

    /** @test */
    public function user_can_access_budget_campaign_endpoint()
    {

        $this->get('/v1/campaigns/' . $this->campaign->uuid . '/budget')
            ->assertStatus(\Illuminate\Http\Response::HTTP_OK)
            ->assertExactJson(
                $this->item($this->campaign->budget, new BudgetTransformer)
            );
    }
}
