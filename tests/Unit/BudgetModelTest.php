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

        $this->assertEquals(1, $campaign->budget->count());
    }
}
