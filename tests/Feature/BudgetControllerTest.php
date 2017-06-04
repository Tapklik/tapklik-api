<?php
use App\Budget;
use App\Transformers\BudgetTransformer;
use Illuminate\Http\Response;
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
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                $this->item($this->campaign->budget, new BudgetTransformer)
            );
    }

    /** @test */
    public function user_can_create_budget_on_campaign()
    {

        $budget = factory(Budget::class)->make();

        $this->post('/v1/campaigns/' . $this->campaign->uuid . '/budget', $budget->toArray())
            ->assertStatus(Response::HTTP_OK);
    }
}
