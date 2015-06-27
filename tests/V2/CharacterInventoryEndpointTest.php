<?php

namespace V2;

use TestCase;

class CharacterInventoryEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->characters('test')->inventory('char');

        $this->mockResponse('{"bags":[{"id":8941,"size":4,"inventory":[null,{"id":32134,"count":1},null,null]},null]}');
        $this->assertEquals(32134, $endpoint->get()[0]->inventory[1]->id);
    }
}
