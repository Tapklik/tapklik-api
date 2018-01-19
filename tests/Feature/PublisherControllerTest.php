<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PublisherControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_list_publisher_sites()
    {
        $publisher = factory(\App\Publisher::class)->create();

        $response = $this->get('v1/core/publishers')->assertStatus(\Illuminate\Http\Response::HTTP_OK);

        $response->assertExactJson([
            'data' => [
                ['id' => $publisher->_id,
                'site' => $publisher->publisher_site]
            ]
        ]);
    }

    /** @test */
    public function it_can_show_specific_publisher()
    {
        $publisher = factory(\App\Publisher::class)->create();

        $response = $this->get('v1/core/publishers/' . $publisher->_id)->assertStatus
        (\Illuminate\Http\Response::HTTP_OK);

        $response->assertExactJson([
            'data' => [
                'id' => $publisher->_id,
                 'site' => $publisher->publisher_site
            ]
        ]);
    }
}
