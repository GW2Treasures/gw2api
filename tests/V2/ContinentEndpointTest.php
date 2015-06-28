<?php

class ContinentEndpointTest extends TestCase {
    public function testIds() {
        $endpoint = $this->api()->continents();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );

        $this->mockResponse('[1,2]');
        $this->assertEquals( [1,2], $endpoint->ids() );
    }
}
