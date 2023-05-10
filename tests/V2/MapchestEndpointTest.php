<?php

class MapchestEndpointTest extends BasicTestCase {
    public function test() {
        $endpoint = $this->api()->mapchests();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/mapchests', $endpoint );

        $this->mockResponse('{"id":"auric_basin_heros_choice_chest"}');
        $this->assertEquals('auric_basin_heros_choice_chest', $endpoint->get('auric_basin_heros_choice_chest')->id);
    }
}
