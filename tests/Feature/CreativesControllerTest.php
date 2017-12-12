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

    /** @test */
    public function it_can_delete_a_creative()
    {
        $creative = factory(\App\Creative::class)->states(['withFolder'])->create();

        $this->assertDatabaseHas('creatives', ['id' => $creative->id]);

        $response = $this->delete('v1/creatives/' . $creative->uuid);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('creatives', ['id' => $creative->id]);
    }

    /** @test */
    public function it_can_attach_attributes_to_creative()
    {
        $creative = factory(\App\Creative::class)->states(['withFolder'])->create();

        $response = $this->post('/v1/creatives/' . $creative->uuid . '/attr', [2,4,6]);

        $creative = \App\Creative::findByUuId($creative->uuid);

        $expected = $this->item($creative, new CreativeTransformer);

        $response->assertExactJson($expected);
    }
}
