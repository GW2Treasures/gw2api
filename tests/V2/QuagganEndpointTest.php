<?php

class QuagganEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->quaggans();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointUrl( 'v2/quaggans', $endpoint );

        $this->mockResponse('{"id":"cheer","url":"https://static.staticwars.com/quaggans/cheer.jpg"}');
        $this->assertStringEndsWith( 'cheer.jpg', $endpoint->get('cheer')->url );
    }
}
