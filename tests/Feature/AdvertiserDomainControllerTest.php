<?php

use App\Campaign;
use App\Transformers\AdvertiserDomainTransformer;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdvertiserDomainControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {

        parent::setUp();

        $this->campaign = factory(Campaign::class)->create();
    }

    /** @test */
    public function user_can_access_adomain_endpoint_through_campaign()
    {

        $this->get('/v1/campaigns/'.$this->campaign->uuid.'/adomain')->assertStatus(Response::HTTP_OK)->assertExactJson(
                $this->collection($this->campaign->advertiserDomains, new AdvertiserDomainTransformer)
            );
    }

    /** @test */
    public function user_can_create_advertiser_domain()
    {

        $advertiserDomain = factory(\App\AdvertiserDomain::class)->make();

        $this->post('/v1/campaigns/' . $this->campaign->uuid . '/adomain', $advertiserDomain->toArray())
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                $this->collection($this->campaign->advertiserDomains, new AdvertiserDomainTransformer)
            );
    }
}
