<?php

use GW2Treasures\GW2Api\V2\Endpoint\Pvp\GameEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Pvp\StatsEndpoint;

class PvpEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->pvp('API_KEY');

        $this->assertEndpointUrl( 'v2/pvp', $endpoint );
        $this->assertEndpointIsAuthenticated( $endpoint );

        $this->assertInstanceOf( GameEndpoint::class, $endpoint->games() );
        $this->assertInstanceOf( StatsEndpoint::class, $endpoint->stats() );
    }
}
