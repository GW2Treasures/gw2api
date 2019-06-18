<?php

class WorldBossEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->worldbosses();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/worldbosses', $endpoint );

        $this->mockResponse('{"id":"karka_queen"}');
        $this->assertEquals('karka_queen', $endpoint->get('karka_queen')->id);
    }
}
