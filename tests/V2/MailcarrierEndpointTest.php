<?php

class MailcarrierEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->mailcarriers();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/mailcarriers', $endpoint );

        $this->mockResponse('[1,2,3,4,5,6,8,12,13]');
        $this->assertEquals( [1,2,3,4,5,6,8,12,13], $endpoint->ids() );
    }
}
