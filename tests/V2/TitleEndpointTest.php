<?php

class TitleEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->titles();

        $this->assertEndpointIsBulk($endpoint);
        $this->assertEndpointIsLocalized($endpoint);
        $this->assertEndpointUrl('v2/titles', $endpoint);

        $this->mockResponse('[1,2,3,4,5,6,7,8,9]');
        $this->assertEquals([1,2,3,4,5,6,7,8,9], $endpoint->ids());
    }
}
