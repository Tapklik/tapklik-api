<?php
use App\Campaign;
use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryModelTest extends TestCase {

    use DatabaseMigrations;

    /** @test */
    public function it_can_associate_category_through_pivot_table()
    {
        $campaign = factory(Campaign::class)->create();
        $category = factory(Category::class)->make();

        $campaign->categories()->save($category);

        $this->assertCount(1, $campaign->categories);
    }
}
