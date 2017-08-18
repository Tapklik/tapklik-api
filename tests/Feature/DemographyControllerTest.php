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

        $this->get('v1/campaigns/'.$this->campaign->uuid.'/user')->assertStatus(Response::HTTP_OK)->assertExactJson(
                $this->item(
                    $this->campaign->demography
                        ?: factory(\App\Demography::class)->create(
                        ['campaign_id' => $this->campaign->id]
                    ),
                    new DemographyTransformer
                )
            );
    }

    /** @test */
    public function user_data_can_be_updated()
    {

        $user = factory(\App\User::class)->create(['first_name' => 'rok', 'account_id' =>
            $this->campaign->account->id]);


        $this->assertDatabaseHas('users', ['first_name' => 'rok', 'id' => $user->id]);

        $result = $this->put(
            'v1/accounts/'.$this->campaign->account->uuid.'/users/'.$user->uuid,
            ['first_name' => 'halid']
        )->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('users', ['first_name' => 'halid', 'id' => $user->id]);

        $result->assertExactJson([
            'data' => [
                'id'         => $user->uuid,
                'first_name' => 'halid',
                'last_name'  => $user->last_name,
                'name'       => 'halid ' . $user->last_name,
                'email'      => $user->email,
                'phone'      => $user->phone,
                'status'     => $user->status
            ]
        ]);
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
