<?php

class PvpGameEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->pvp('API_KEY')->games();

        $this->assertEndpointUrl( 'v2/pvp/games', $endpoint );
        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointIsBulk( $endpoint );

        $this->mockResponse( '["A9F9FD97-F114-4F97-B2CA-5E814DF0340E","4FDC931F-677F-4369-B20A-9FBB6A63B2B4"]' );
        $this->assertContains( '4FDC931F-677F-4369-B20A-9FBB6A63B2B4', $endpoint->ids() );
    }
}
