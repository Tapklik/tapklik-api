<?php

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

        $this->acc = factory(App\Account::class)->create();
        $this->user = factory(App\User::class)->create([
            'account_id' => $this->account = 1
        ]);
    }

    /** @test */
    public function user_can_list_folders () {

        $folders = factory(\App\Folder::class, 10)->create();

        $this->get('/v1/creatives/folders', [
            'Authorization' => 'Bearer ' . $this->generateApiTokenForUser($this->user)
        ])
        ->assertStatus(Response::HTTP_OK);
    }
}
