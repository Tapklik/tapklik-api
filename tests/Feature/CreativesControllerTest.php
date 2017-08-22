<?php

use App\Transformers\CreativeTransformer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreativesControllerTest extends TestCase {

    use DatabaseMigrations, WithoutMiddleware;

    /** @test */
    public function it_can_retrieve_creative() 
    {

        $creative = factory(\App\Creative::class)->states('withFolder')->create();

        $response = $this->get('v1/creatives/' . $creative->uuid)->assertStatus(Response::HTTP_OK);

        $response->assertExactJson(
            $this->item($creative, new CreativeTransformer)
        );

    }
}
