<?php

class FileEndpointTest extends TestCase {
    public function testIds() {
        $endpoint = $this->api()->files();

        $this->assertEndpointIsBulk( $endpoint );

        $this->mockResponse('["map_complete","map_dungeon","map_heart_empty","map_heart_full"]');
        $this->assertContains( 'map_heart_empty', $endpoint->ids() );
    }
}
