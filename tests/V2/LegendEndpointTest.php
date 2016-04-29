<?php

class LegendEndpointTest extends TestCase {
    public function testLegends() {
        $endpoint = $this->api()->legends();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointUrl( 'v2/legends', $endpoint );

        $this->mockResponse('{"id":"Legend1","swap":28229,"heal":27220,"elite":27760,"utilities":[28379,27014,26644]}');
        $this->assertEquals('27220', $endpoint->get('Legend1')->heal);
    }
}
