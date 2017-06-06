<?php

use App\Campaign;
use App\Exchange;
use App\Transformers\CreativeTransformer;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CampaignCreativeControllerTest extends TestCase
{

    use DatabaseMigrations, WithoutMiddleware;

    public function setUp()
    {

        parent::setUp();

        $this->campaign = factory(Campaign::class)->create();
    }

    /** @test */
    public function user_can_view_creatives_on_campaign_endpoint()
    {
        factory(\App\Creative::class)
            ->make()
            ->each(function ($creative) {

                $this->campaign->creatives()->save($creative);
        });

        $this->get('/v1/campaigns/' . $this->campaign->uuid . '/creatives')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                $this->collection($this->campaign->creatives, new CreativeTransformer)
            );
    }
}
