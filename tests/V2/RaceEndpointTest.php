<?php

class RaceEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->races();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/races', $endpoint );

        $this->mockResponse('["Human","Asura","Sylvari","Charr","Norn"]');
        $this->assertEquals( ["Human","Asura","Sylvari","Charr","Norn"], $endpoint->ids() );
    }
}
