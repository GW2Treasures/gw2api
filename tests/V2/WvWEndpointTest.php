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

    public function testMatchEndpoint() {
        $endpoint = $this->api()->wvw()->matches();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointUrl( 'v2/wvw/matches', $endpoint );

        $this->mockResponse('{"id":"2-6","scores":{"red":169331,"blue":246780,"green":216241}}');
        $this->assertEquals(169331, $endpoint->world('id')->scores->red);
    }
}
