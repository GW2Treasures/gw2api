<?php

class MapEndpointTest extends TestCase {
    public function test() {
        $this->mockResponse('{
            "id": 15,
            "name": "Queensdale",
            "min_level": 1,
            "max_level": 15,
            "default_floor": 1,
            "floors": [0,1,2],
            "region_id": 4,
            "region_name": "Kryta",
            "continent_id": 1,
            "continent_name": "Tyria",
            "map_rect": [[-43008,-27648],[43008,30720]],
            "continent_rect": [[9856,11648],[13440,14080]]
        }');

        $this->assertEquals( 'Queensdale', $this->api()->maps()->get(15)->name );
    }
}
