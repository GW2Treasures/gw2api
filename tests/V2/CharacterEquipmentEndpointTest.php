<?php

namespace V2;

use TestCase;

class CharacterEquipmentEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->characters('test')->equipmentOf('char');

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/characters/char/equipment', $endpoint );

        $this->mockResponse('{"equipment":[{"id":6472,"slot":"Coat"},{"id":6470,"slot":"Boots"}]}');
        $this->assertEquals(6472, $endpoint->get()[0]->id);
    }

    public function testCharacterNameEncoding() {
        $endpoint = $this->api()->characters('test')->equipmentOf('Character Namè');

        $this->assertEndpointUrl( 'v2/characters/Character%20Nam%C3%A8/equipment', $endpoint );
    }
}
