<?php

class CurrencyEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->currencies();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/currencies', $endpoint );

        $this->mockResponse('[1,2,3,4,5]');
        $this->assertEquals( [1,2,3,4,5], $endpoint->ids() );
    }
}
