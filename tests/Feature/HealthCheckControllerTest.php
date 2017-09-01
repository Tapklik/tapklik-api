<?php

use Illuminate\Http\Response;
use Tests\TestCase;

class HealthCheckControllerTest extends TestCase {
    
    /** @test */
    public function it_can_return_health_status() 
    {
        $this->get('/v1/health')
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(['status' => 'OK']);
    }
}
