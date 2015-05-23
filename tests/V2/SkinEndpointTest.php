<?php

class SkinEndpointTest extends TestCase {
    public function test() {
        $this->mockResponse('[1,2,3,4,5,6,7,8,9,10]');

        $this->assertEquals( [1,2,3,4,5,6,7,8,9,10], $this->api()->skins()->ids() );
    }
}
