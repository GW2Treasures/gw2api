<?php

class SkinEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->skins();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/skins', $endpoint );

        $this->mockResponse('[1,2,3,4,5,6,7,8,9,10]');
        $this->assertEquals( [1,2,3,4,5,6,7,8,9,10], $endpoint->ids() );
    }
}
