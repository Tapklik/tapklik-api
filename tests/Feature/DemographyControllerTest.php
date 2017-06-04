<?php

use App\Campaign;
use App\Transformers\DemographyTransformer;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DemographyControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {

        parent::setUp();

        $this->campaign = factory(Campaign::class)->create();
    }

    /** @test */
    public function user_can_view_user_endpoint_on_campaign()
    {
        $this->get('v1/campaigns/' . $this->campaign->uuid . '/user')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                $this->item(
                    $this->campaign->demography ?: factory(\App\Demography::class)->create([
                        'campaign_id' => $this->campaign->id
                    ]),
                    new DemographyTransformer
                )
            );
    }

//    /** @test */
//    public function user_can_create_exchange()
//    {
//        $exchange = factory(Exchange::class)->make();
//
//        $this->post('/v1/campaigns/' . $this->campaign->uuid . '/exchange', $exchange->toArray())
//            ->assertStatus(Response::HTTP_OK)
//            ->assertExactJson(
//                $this->collection($this->campaign->exchanges, new ExchangeTransformer)
//            );
//    }
}
