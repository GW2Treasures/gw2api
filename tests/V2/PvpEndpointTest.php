<?php

class PvpEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->pvp('API_KEY');

        $this->assertEndpointUrl( 'v2/pvp', $endpoint );
        $this->assertEndpointIsAuthenticated( $endpoint );

        $this->assertInstanceOf( '\GW2Treasures\GW2Api\V2\Endpoint\Pvp\GameEndpoint', $endpoint->games() );
        $this->assertInstanceOf( '\GW2Treasures\GW2Api\V2\Endpoint\Pvp\StatsEndpoint', $endpoint->stats() );
    }
}
