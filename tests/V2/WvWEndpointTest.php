<?php

class WvWEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->wvw();

        $this->assertEndpointUrl( 'v2/wvw', $endpoint );
    }

    public function testAbilityEndpoint() {
        $endpoint = $this->api()->wvw()->abilities();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/wvw/abilities', $endpoint );

        $this->mockResponse('[2,3,4,5,6,7,8,9,10,11,12,14,15,16,17,18,19,20,23,24]');
        $this->assertEquals( [2,3,4,5,6,7,8,9,10,11,12,14,15,16,17,18,19,20,23,24], $endpoint->ids() );
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
