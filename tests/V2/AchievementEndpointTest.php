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

    public function testCategories() {
        $endpoint = $this->api()->achievements()->categories();

        $this->assertEndpointUrl('v2/achievements/categories', $endpoint);
        $this->assertEndpointIsBulk($endpoint);
        $this->assertEndpointIsLocalized($endpoint);

        $this->mockResponse('{"id":50,"name":"Twilight Assault","description":"","order":0,"achievements":[947]}');
        $this->assertEquals(947, $endpoint->get(50)->achievements[0]);
    }

    public function testDaily() {
        $endpoint = $this->api()->achievements()->daily();

        $this->assertEndpointUrl( 'v2/achievements/daily', $endpoint );

        $this->mockResponse('{"pve":[{"id":1984,"level":{"min":1,"max":80}}]}');
        $this->assertEquals(1984, $endpoint->get()->pve[0]->id);
    }
}
