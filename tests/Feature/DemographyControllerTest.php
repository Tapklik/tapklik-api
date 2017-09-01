<?php

use App\Campaign;
use App\Transformers\DemographyTransformer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DemographyControllerTest extends TestCase
{

    use DatabaseMigrations, WithoutMiddleware;

    public function setUp()
    {

        parent::setUp();

        $this->campaign = factory(Campaign::class)->create();
    }

    /** @test */
    public function user_can_view_user_endpoint_on_campaign()
    {

        $repsonse = $this->get('v1/campaigns/'.$this->campaign->uuid.'/users')
            ->assertStatus(Response::HTTP_OK);

        $repsonse->assertExactJson(
                $this->item(
                    $this->campaign->demography  ?: factory(\App\Demography::class)->create([
                        'campaign_id' => $this->campaign->id
                    ]),
                    new DemographyTransformer
                )
            );
    }
}
