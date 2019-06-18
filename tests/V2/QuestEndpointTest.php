<?php

class QuestTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->quests();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/quests', $endpoint );

        $this->mockResponse('{"id":"15", "name": "Explosive Intellect"}');
        $this->assertEquals('Explosive Intellect', $endpoint->get(15)->name);
    }
}
