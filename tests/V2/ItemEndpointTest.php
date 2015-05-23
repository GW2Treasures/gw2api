<?php

class ItemEndpointTest extends TestCase {
    public function testIds() {
        $this->mockResponse('[1,2,6,11,24,56,57,58,59]');

        $this->assertEquals( [1,2,6,11,24,56,57,58,59], $this->api()->items()->ids() );
    }
}
