<?php

use App\Transformers\CreativeTransformer;
use App\Transformers\FolderTransformer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FolderControllerTest extends TestCase
{

    use DatabaseMigrations;


    public function setUp()
    {

        parent::setUp();

        $this->acc    = factory(App\Account::class)->create();
        $this->user   = factory(App\User::class)->create(['account_id' => $this->acc->id]);
        $this->folder = factory(\App\Folder::class)->create(['account_id' => $this->acc->id]);
    }

    /** @test */
    public function user_can_list_folders () {

        $createdFoldersCount = 10;

        $folders = factory(\App\Folder::class, $createdFoldersCount)->create([
            'account_id' => $this->acc->id
        ]);

        $page = $this->get('/v1/creatives/folders', [
            'Authorization' => 'Bearer ' . $this->generateApiTokenForUser($this->user)
        ])
        ->assertStatus(Response::HTTP_OK)
        ->assertExactJson(
            $this->collection($folders, new FolderTransformer)
        );

        $actualFoldersCount = $page->decodeResponseJson()['data'];

        $this->assertCount($createdFoldersCount, $actualFoldersCount);
    }

    /** @test */
    public function user_can_view_a_folder()
    {
        $createdCreativesCount = 20;
        $creatives = factory(\App\Creative::class, $createdCreativesCount)->create(['folder_id' => $this->folder->id]);

        $page = $this->get('/v1/creatives/folders/' . $this->folder->uuid, [
            'Authorization' => 'Bearer ' . $this->generateApiTokenForUser($this->user)
        ])
        ->assertStatus(Response::HTTP_OK)
        ->assertExactJson(
            $this->collection($creatives, new CreativeTransformer)
        );

        $actualCreativesCount = $page->decodeResponseJson()['data'];

        $this->assertEquals($createdCreativesCount, count($actualCreativesCount));
    }
}
