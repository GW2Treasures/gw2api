<?php

class AchievementEndpointTest extends TestCase {
    public function testIds() {
        $endpoint = $this->api()->minis();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/minis', $endpoint );

        $this->mockResponse('{"id":1,"name":"Miniature Rytlock","order":1,"item_id":21047}');
        $this->assertEquals('Miniature Rytlock', $endpoint->get(1)->name);
    }
}
