<?php

class MiniEndpointTest extends TestCase {
    public function testIds() {
        $endpoint = $this->api()->achievements();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/achievements', $endpoint );

        $this->mockResponse('{"id":1,"name":"Centaur Slayer"}');
        $this->assertEquals('Centaur Slayer', $endpoint->get(1)->name);
    }
}
