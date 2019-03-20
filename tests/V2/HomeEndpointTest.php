<?php

class HomeEndpointTest extends TestCase {
    public function testMounts() {
        $endpoint = $this->api()->home();

        $this->assertEndpointUrl( 'v2/home', $endpoint );
    }

    public function testHomeCats() {
        $endpoint = $this->api()->home()->cats();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointUrl( 'v2/home/cats', $endpoint );

        $this->mockResponse('{"hint":"chicken","id":1}');
        $this->assertEquals('chicken', $endpoint->get(1)->hint);
    }

    public function testHomeNodes() {
        $endpoint = $this->api()->home()->nodes();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointUrl( 'v2/home/nodes', $endpoint );

        $this->mockResponse('{"id":"advanced_cloth_rack"}');
        $this->assertEquals('advanced_cloth_rack', $endpoint->get('advanced_cloth_rack')->id);
    }
}
