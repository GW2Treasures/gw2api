<?php

class MiniEndpointTest extends TestCase {
    public function testAchievements() {
        $endpoint = $this->api()->achievements();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/achievements', $endpoint );

        $this->mockResponse('{"id":1,"name":"Centaur Slayer"}');
        $this->assertEquals('Centaur Slayer', $endpoint->get(1)->name);
    }

    public function testDaily() {
        $endpoint = $this->api()->achievements()->daily();

        $this->assertEndpointUrl( 'v2/achievements/daily', $endpoint );

        $this->mockResponse('{"pve":[{"id":1984,"level":{"min":1,"max":80}}]}');
        $this->assertEquals(1984, $endpoint->get()->pve[0]->id);
    }
}
