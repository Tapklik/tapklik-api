<?php namespace Tests\Unit;

use App\AdvertiserDomain;
use App\Campaign;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdvertiserDomainTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function it_can_attach_advertiser_domain_to_a_campaign()
    {

        $campaign = factory(Campaign::class)->create();

        factory(AdvertiserDomain::class, 2)
            ->make()
            ->each(function ($adomain) use ($campaign) {

                $campaign->advertiserDomains()->save($adomain);
            });


        $this->assertCount(2, $campaign->advertiserDomains);
    }
}
