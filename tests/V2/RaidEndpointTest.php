<?php

class RaidEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->raids();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/raids', $endpoint );

        $this->mockResponse('["forsaken_thicket"]');
        $this->assertEquals( ["forsaken_thicket"], $endpoint->ids() );
    }
}
