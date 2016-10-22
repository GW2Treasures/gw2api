<?php

class ItemstatEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->itemstats();

        $this->assertEndpointIsBulk($endpoint);
        $this->assertEndpointIsLocalized($endpoint);
        $this->assertEndpointUrl('v2/itemstats', $endpoint);

        $this->mockResponse('{"id":137,"name":"Mighty","attributes":{"Power":0.35}}');
        $this->assertEquals('Mighty', $endpoint->get(137)->name);
    }
}
