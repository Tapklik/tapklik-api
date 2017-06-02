<?php namespace Tests\Unit;

use App\AdvertiserDomain;
use App\Campaign;
use App\Exchange;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExchangeModelTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function it_can_attach_exchange_to_a_campaign()
    {

        $campaign = factory(Campaign::class)->create();

        factory(Exchange::class, 2)
            ->make()
            ->each(function ($exchange) use ($campaign) {

                $campaign->exchanges()->save($exchange);
            });

        $this->assertCount(2, $campaign->exchanges);
    }
}
