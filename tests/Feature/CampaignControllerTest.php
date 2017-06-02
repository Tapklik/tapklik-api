<?php

namespace Tests\Feature;

use App\Campaign;
use App\Transformers\CampaignTransformer;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CampaignControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {

        parent::setUp();

        $this->campaign = factory(Campaign::class)->create();
    }

    /** @test */
    public function user_can_list_campaigns()
    {

        $this->get('/v1/campaigns')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson($this->collection(Campaign::all(), new CampaignTransformer));
    }


    /** @test */
    public function user_can_query_specific_campaign()
    {

        $this->get('/v1/campaigns/' . $this->campaign->uuid)
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                $this->item($this->campaign, new CampaignTransformer)
            );
    }

    /** @test */
    public function non_existing_campaign_should_return_error()
    {

        $this->get('/v1/campaigns/does-not-exist')
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => [
                    'code' => 404,
                    'message' => 'Not found',
                    'details' => 'Campaign does-not-exist does not exist.'
                ]
            ]);
    }
}
