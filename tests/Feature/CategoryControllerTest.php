<?php

namespace Tests\Feature;

use App\Campaign;
use App\Category;
use App\Transformers\CampaignTransformer;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @property mixed campaign
 */
class CategoryControllerTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function user_can_save_category_to_campaign()
    {
        $campaign = factory(Campaign::class)->create();
        $categories = factory(Category::class, 4)->create();

        $page = $this->post('/v1/campaigns/' . $campaign->uuid . '/cat', $categories->pluck('id')->toArray())
            ->assertStatus(Response::HTTP_OK);


        $page = $page->decodeResponseJson();

        $this->assertCount(count($page['data']), $campaign->categories);
    }
}
