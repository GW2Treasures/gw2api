<?php

class WorldEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->worlds();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/worlds', $endpoint );

        $this->mockResponse('[{"id":1001,"name":"Anvil Rock"}]');
        $this->assertEquals( 'Anvil Rock', $endpoint->many([1001])[0]->name );
    }
}
