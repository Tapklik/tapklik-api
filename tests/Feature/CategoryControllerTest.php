<?php

namespace Tests\Feature;

use App\Campaign;
use App\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @property mixed campaign
 */
class CategoryControllerTest extends TestCase
{

    use DatabaseMigrations, WithoutMiddleware;

    public function setUp()
    {

        parent::setUp();

        $this->campaign = factory(Campaign::class)->create();
    }

    /** @test */
    public function user_can_view_categories_endpoint()
    {
        $cat = factory(Category::class)->create();
        $this->campaign->categories()->save($cat);

        $this->get('/v1/campaigns/' . $this->campaign->uuid . '/cat')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                $this->collection($this->campaign->categories, new CategoryTransformer)
            );
    }
    /** @test */
    public function user_can_save_category_to_campaign()
    {
        $categories = factory(Category::class, 4)->create();

        $page = $this->post('/v1/campaigns/' . $this->campaign->uuid . '/cat', $categories->pluck('code')->toArray())
            ->assertStatus(Response::HTTP_OK);


        $page = $page->decodeResponseJson();

        $this->assertEquals(count($page['data']), 4);
    }
}
