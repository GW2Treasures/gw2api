<?php

class WorldEndpointTest extends TestCase {
    public function test() {
        $this->mockResponse('[{"id":1001,"name":"Anvil Rock"}]');

        $this->assertEquals( 'Anvil Rock', $this->api()->worlds()->many([1001])[0]->name );
    }
}
