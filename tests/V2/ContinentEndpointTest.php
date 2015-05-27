<?php

class ContinentEndpointTest extends TestCase {
    public function testIds() {
        $this->mockResponse('[1,2]');

        $this->assertEquals( [1,2], $this->api()->continents()->ids() );
    }
}
