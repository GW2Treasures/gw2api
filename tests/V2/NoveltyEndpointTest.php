<?php

class NoveltyEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->novelties();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/novelties', $endpoint );

        $this->mockResponse('{"id":1,"name":"Embellished Kite"}');
        $this->assertEquals('Embellished Kite', $endpoint->get(1)->name);
    }
}
