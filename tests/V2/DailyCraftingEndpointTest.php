<?php

class DailyCraftingEndpointTest extends BasicTestCase {
    public function test() {
        $endpoint = $this->api()->dailycrafting();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/dailycrafting', $endpoint );

        $this->mockResponse('{"id":"lump_of_mithrilium"}');
        $this->assertEquals('lump_of_mithrilium', $endpoint->get('lump_of_mithrilium')->id);
    }
}
