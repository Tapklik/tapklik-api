<?php
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class BankerControllerTest extends TestCase {

    use DatabaseMigrations, WithoutMiddleware;

    /** @test */
    public function it_it_can_query_type() 
    {
        $campaign = factory(\App\Campaign::class)->create();
        $bankerBilling = factory(\App\BankerMain::class, 20)->states(['withTypeBilling'])->create([
            'mainable_type' => \App\Campaign::class,
            'mainable_id' => $campaign->id
        ]);

        $response = $this->get('/v1/campaigns/' . $campaign->uuid . '/banker/main?type=billing')->assertStatus
        (\Illuminate\Http\Response::HTTP_OK);

        $json = $response->decodeResponseJson()['data'];

        $this->assertCount($bankerBilling->count(), $json);
    }
}
