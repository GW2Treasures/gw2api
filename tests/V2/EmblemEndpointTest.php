<?php

use GW2Treasures\GW2Api\V2\Endpoint\Emblem\LayerEndpoint;

class EmblemEndpointTest extends TestCase {
    public function testEmblem() {
        $endpoint = $this->api()->emblem();

        $this->assertEndpointUrl('v2/emblem', $endpoint);

        $this->assertInstanceOf(LayerEndpoint::class, $endpoint->backgrounds());
        $this->assertInstanceOf(LayerEndpoint::class, $endpoint->foregrounds());
    }

    public function testForeground() {
        $endpoint = $this->api()->emblem()->foregrounds();

        $this->assertEndpointUrl('v2/emblem/foregrounds', $endpoint);
        $this->assertEndpointIsBulk($endpoint);

        $this->mockResponse('{"id": 1,"layers":["1.png","2.png","3.png"]}');

        $this->assertEquals(1, $endpoint->get(1)->id);
    }

    public function testTypes() {
        $backgrounds = $this->api()->emblem()->backgrounds();
        $foregrounds = $this->api()->emblem()->foregrounds();

        $this->assertEndpointUrl('v2/emblem/backgrounds', $backgrounds);
        $this->assertEndpointUrl('v2/emblem/foregrounds', $foregrounds);
    }

    /** @expectedException \InvalidArgumentException */
    public function testInvalidLayerType() {
        new LayerEndpoint($this->api(), 'invalid');
    }
}
