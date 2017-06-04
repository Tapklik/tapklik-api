<?php
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BudgetModelTest extends TestCase {

    use DatabaseMigrations;

    /** @test */
    public function it_can_attach_budget_to_campaign() 
    {
        $campaign = factory(\App\Campaign::class)->create();
        $budget   = factory(\App\Budget::class)->make();

        $campaign->budget()->save($budget);

        // Since we have observer on create campaign which attaches a default budget
        // the count will be 2 in this case as we are creating additional budget
        $this->assertEquals(2, $campaign->budget->count());
    }
}
