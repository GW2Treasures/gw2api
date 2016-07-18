<?php

class ProfessionEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->professions();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/professions', $endpoint );

        $this->mockResponse('["Guardian","Warrior","Engineer","Ranger","Thief","Elementalist","Mesmer","Necromancer","Revenant"]');
        $this->assertEquals( ["Guardian","Warrior","Engineer","Ranger","Thief","Elementalist","Mesmer","Necromancer","Revenant"], $endpoint->ids() );
    }
}
