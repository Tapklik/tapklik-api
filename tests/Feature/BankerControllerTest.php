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

    /** @test */
    public function it_can_add_spend_to_banker_main_table()
    {
        $campaign = factory(\App\Campaign::class)->create();
        $bankerBilling = factory(\App\BankerMain::class)->states(['withTypeBilling'])->make();

        $response = $this->post('/v1/campaigns/' . $campaign->uuid . '/banker/main', $bankerBilling->toArray())
        ->assertStatus(\Illuminate\Http\Response::HTTP_OK);

        $this->assertDatabaseHas('banker_main', ['credit' => $bankerBilling->credit]);
    }
}
