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

        $createdFoldersCount = 10; // Add one because there is a folder creation in constructor for this account

        $folders = factory(\App\Folder::class, $createdFoldersCount)->create([
            'account_id' => $this->acc->id
        ]);

        $page = $this->get('/v1/creatives/folders', [
            'Authorization' => 'Bearer ' . $this->generateApiTokenForUser($this->user)
        ])
        ->assertStatus(Response::HTTP_OK);

        $actualFoldersCount = $page->decodeResponseJson()['data'];

        $this->assertCount($createdFoldersCount + 1, $actualFoldersCount);
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

    /** @test */
    public function user_can_create_a_folder()
    {

        $folder = factory(\App\Folder::class)->make(['name' => 'Created']);

        $page = $this->post(
            'v1/creatives/folders',
            $folder->toArray(),
            [
                'Authorization' => 'Bearer '.$this->generateApiTokenForUser($this->user),
            ]
        )->assertStatus(Response::HTTP_OK);

        $expectingFolder = \App\Folder::where(['name' => 'Created'])->first();
        $this->assertDatabaseHas('folders', $expectingFolder->toArray());

        $page->assertExactJson(
            $this->item($expectingFolder, new FolderTransformer)
        );
    }



    /** @test */
    public function it_throws_an_error_if_folder_deleted_contains_creatives()
    {
        $this->withoutMiddleware();

        $creative = factory(\App\Creative::class)->create(['folder_id' => $this->folder->id]);

        $response = $this->delete('v1/creatives/folders/' . $this->folder->uuid);

        $this->assertDatabaseHas('folders', ['id' => $this->folder->id]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $response->assertExactJson([
            'error' => [
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => 'Folder is not empty',
                'details' => 'N/A',
                'request' => ''
            ]
        ]);
    }

    /** @test */
    public function it_can_delete_empty_folder()
    {
        $this->withoutMiddleware();

        $this->assertDatabaseHas('folders', ['id' => $this->folder->id]);

        $response = $this->delete('v1/creatives/folders/' . $this->folder->uuid);

        $this->assertDatabaseMissing('folders', ['id' => $this->folder->id]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
