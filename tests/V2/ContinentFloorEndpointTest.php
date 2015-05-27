<?php

class ContinentFloorEndpointTest extends TestCase {
    public function testIds() {
        $this->mockResponse('{"texture_dims":[32768,32768],"clamped_view":[[1662,2816],[12544,8062]],"regions":{},"id":42}');

        $this->assertEquals( [32768,32768], $this->api()->continents()->floors(1)->get(42)->texture_dims );
    }
}
