<?php

class TraitEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->traits();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/traits', $endpoint );

        $this->mockResponse('[214,221,222,223]');
        $this->assertEquals( [214,221,222,223], $endpoint->ids() );
    }
}
