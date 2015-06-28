<?php

namespace V2;

use TestCase;

class CharacterEquipmentEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->characters('test')->equipment('char');

        $this->assertEndpointIsAuthenticated( $endpoint );

        $this->mockResponse('{"equipment":[{"id":6472,"slot":"Coat"},{"id":6470,"slot":"Boots"}]}');
        $this->assertEquals(6472, $endpoint->get()[0]->id);
    }
}
