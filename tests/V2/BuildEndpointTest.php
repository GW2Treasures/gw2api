<?php

class BuildEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->build();

        $this->mockResponse( '{"id":1337}' );
        $this->assertEquals( 1337, $endpoint->get() );
    }
}
