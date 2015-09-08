<?php

class PvpStatsEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->pvp('API_KEY')->stats();

        $this->assertEndpointUrl( 'v2/pvp/stats', $endpoint );
        $this->assertEndpointIsAuthenticated( $endpoint );

        $this->mockResponse( '{"pvp_rank":57}' );
        $this->assertEquals( 57, $endpoint->get()->pvp_rank );
    }
}
