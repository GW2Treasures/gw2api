<?php

class BuildEndpointTest extends TestCase {
    public function test() {
        $this->mockResponse( '{"id":1337}' );
        $this->assertEquals( 1337, $this->api()->build()->get() );
    }
}
