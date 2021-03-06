<?php

namespace Tests\Feature;

use App\Account;
use App\Campaign;
use App\Transformers\CampaignTransformer;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @property mixed campaign
 */
class CampaignControllerTest extends TestCase
{

    use DatabaseMigrations, WithoutMiddleware;

    public function setUp()
    {

        parent::setUp();

        $this->campaign = factory(Campaign::class)->create(['account_id' => 1]);
    }

    /** @test */
    public function user_can_create_campaign()
    {
        $withName = 'Test name';
        $campaign = factory(Campaign::class)->make(['name' => $withName]);

        $this->assertDatabaseMissing('campaigns', [
            'name' => $withName
        ]);

        $response = $this->post('/v1/campaigns', $campaign->toArray());


        $this->assertDatabaseHas('campaigns', [
            'name' => $withName
        ]);
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
                    'code'    => 404,
                    'message' => 'Not found',
                    'details' => 'Campaign does-not-exist does not exist.',
                ],
            ]);
    }

    /** @test */
    public function user_can_update_campaign()
    {

        $update = [
            'name'        => 'Updated name',
            'description' => 'Updated description',
            'start'       => '2017-01-01',
            'end'         => '2017-01-02',
            'bid'         => 9999,
            'ctrurl'      => 'updated-ctr-url',
            'test'        => 0,
            'weight'      => 0
        ];

        $this->assertDatabaseMissing('campaigns', $update);


        $this->put('/v1/campaigns/' . $this->campaign->uuid, $update)
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                $this->item(
                    Campaign::findByUuId($this->campaign->uuid), new CampaignTransformer
                )
            );

        $this->assertDatabaseHas('campaigns', $update);
    }

    /** @test */
    public function it_should_not_updated_id()
    {
        $this->put('/v1/campaigns/' . $this->campaign->uuid, [
            'id'   => 999,
        ])
        ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('campaigns', [
            'id'   => $this->campaign->id,
        ]);
    }

    /** @test */
    public function user_can_delete_campaign()
    {
        $this->delete('/v1/campaigns/' . $this->campaign->uuid)
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'data' => ''
            ]);

        $this->assertDatabaseMissing('campaigns', ['uuid' => $this->campaign->uuid]);
    }
}
