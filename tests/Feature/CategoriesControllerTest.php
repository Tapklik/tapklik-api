<?php
use App\Account;
use App\Transformers\AccountTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CategoriesControllerTest extends TestCase {

    use DatabaseMigrations, WithoutMiddleware;

   /** @test */
   public function it_can_list_categories()
   {

   	    $categories = factory(\App\Category::class, 10)->create();



   }
}
