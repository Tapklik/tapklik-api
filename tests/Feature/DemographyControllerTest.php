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

        $repsonse = $this->get('v1/campaigns/'.$this->campaign->uuid.'/user')
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

    /** @test */
    public function it_can_delete_previous_user_from_campaign_targeting()
    {

        $this->put('v1/campaigns/'.$this->campaign->uuid.'/user', ['gender' => 'M', 'from_age' => 55, 'to_age' => 120])
            ->assertStatus(Response::HTTP_OK);

        $this->put(
            'v1/campaigns/'.$this->campaign->uuid.'/user',
            ['gender'   => 'M',
             'from_age' => 18,
             'to_age'   => 120]
        )->assertStatus(Response::HTTP_OK);

        $this->assertEquals(1, $this->campaign->demography->count());
    }
}
