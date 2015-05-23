<?php

class ColorEndpointTest extends TestCase {
    public function testIds() {
        $this->mockResponse('[1,2,3,4,5,6,7,8,9,10]');

        $this->assertCount( 10, $this->api()->colors()->ids() );
    }
}
