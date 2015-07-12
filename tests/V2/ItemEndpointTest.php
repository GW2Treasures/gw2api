<?php

class ItemEndpointTest extends TestCase {
    public function testIds() {
        $endpoint = $this->api()->items();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/items', $endpoint );

        $this->mockResponse('[1,2,6,11,24,56,57,58,59]');
        $this->assertEquals( [1,2,6,11,24,56,57,58,59], $endpoint->ids() );
    }
}
