<?php

class ColorEndpointTest extends TestCase {
    public function testIds() {
        $endpoint = $this->api()->colors();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/colors', $endpoint );

        $this->mockResponse('[1,2,3,4,5,6,7,8,9,10]');
        $this->assertCount( 10, $endpoint->ids() );
    }
}
