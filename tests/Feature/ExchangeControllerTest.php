<?php

use App\Campaign;
use App\Exchange;
use App\Transformers\ExchangeTransformer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExchangeControllerTest extends TestCase
{

    use DatabaseMigrations, WithoutMiddleware;

    public function setUp()
    {

        parent::setUp();

        $this->campaign = factory(Campaign::class)->create();
    }

    /** @test */
    public function user_can_view_exchanges_endpoint_on_campaign()
    {
        $this->get('v1/campaigns/' . $this->campaign->uuid . '/exchange')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                $this->collection($this->campaign->exchanges, new ExchangeTransformer)
            );
    }

    /** @test */
    public function user_can_create_exchange()
    {
        $exchange = factory(Exchange::class)->make();
        var_dump($exchange->toArray());

        $this->post('/v1/campaigns/' . $this->campaign->uuid . '/exchange', $exchange->toArray())
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                $this->collection($this->campaign->exchanges, new ExchangeTransformer)
            );
    }
}
