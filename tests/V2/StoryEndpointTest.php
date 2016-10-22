<?php

class StoryEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->stories();

        $this->assertEndpointIsBulk($endpoint);
        $this->assertEndpointIsLocalized($endpoint);
        $this->assertEndpointUrl('v2/stories', $endpoint);

        $this->mockResponse('{"id":1,"season":"215AAA0F-CDAC-4F93-86DA-C155A99B5784","name":"My Story"}');
        $this->assertEquals('My Story', $endpoint->get(1)->name);
    }

    public function testSeasons() {
        $endpoint = $this->api()->stories()->seasons();

        $this->assertEndpointIsBulk($endpoint);
        $this->assertEndpointIsLocalized($endpoint);
        $this->assertEndpointUrl('v2/stories/seasons', $endpoint);

        $this->mockResponse('{"id":"B8901E58-DC9D-4525-ADB2-79C93593291E","name":"Heart of Thorns"}');
        $this->assertEquals('Heart of Thorns', $endpoint->get('B8901E58-DC9D-4525-ADB2-79C93593291E')->name);
    }
}
