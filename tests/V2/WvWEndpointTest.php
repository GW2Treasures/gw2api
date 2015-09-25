<?php

class WvWEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->wvw();

        $this->assertEndpointUrl( 'v2/wvw', $endpoint );
    }

    public function testObjectiveEndpoint() {
        $endpoint = $this->api()->wvw()->objectives();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/wvw/objectives', $endpoint );

        $this->mockResponse('{"id": "968-98","name": "Wurm Tunnel"}');
        $this->assertEquals( 'Wurm Tunnel', $endpoint->get('968-98')->name );
    }
}
