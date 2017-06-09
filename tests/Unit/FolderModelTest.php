<?php
use App\Folder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FolderModelTest extends TestCase {

    /**
     *
     */
    public function setUp()
    {

        parent::setUp();

        $this->folder = new Folder();
    }

    /** @test */
    public function it_has_creatives_relationship() 
    {

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $this->folder->creatives());
    }
}
