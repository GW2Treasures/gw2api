<?php

class FileEndpointTest extends TestCase {
    public function testIds() {
        $this->mockResponse('["map_complete","map_dungeon","map_heart_empty","map_heart_full"]');

        $this->assertContains( 'map_heart_empty', $this->api()->files()->ids() );
    }
}
