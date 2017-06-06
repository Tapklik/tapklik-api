<?php

use App\Campaign;
use App\Transformers\GeographyTransformer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GeographyControllerTest extends TestCase
{

    use DatabaseMigrations, WithoutMiddleware;

    public function setUp()
    {

        parent::setUp();

        $this->campaign = factory(Campaign::class)->create();
    }

    /** @test */
    public function user_can_view_geo_data_in_geo_endpoint_on_campaign()
    {
        $this->get('/v1/campaigns/' . $this->campaign->uuid . '/geo')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                $this->collection($this->campaign->geography, new GeographyTransformer)
            );
    }

}
