<?php

class WorldEndpointTest extends TestCase {
    public function test() {
        $endpoints = $this->api()->worlds();

        $this->assertEndpointIsBulk( $endpoints );
        $this->assertEndpointIsLocalized( $endpoints );

        $this->mockResponse('[{"id":1001,"name":"Anvil Rock"}]');
        $this->assertEquals( 'Anvil Rock', $endpoints->many([1001])[0]->name );
    }
}
