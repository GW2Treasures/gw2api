<?php

class DungeonEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->dungeons();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/dungeons', $endpoint );

        $this->mockResponse('{"id":"ascalonian_catacombs","paths":[{"id":"hodgins"},{"id":"detha"},{"id":"tzark"}]}');
        $this->assertCount(3, $endpoint->get('ascalonian_catacombs')->paths);
    }
}
