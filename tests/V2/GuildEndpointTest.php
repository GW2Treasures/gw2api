<?php

class GuildEndpointTest extends TestCase {
    public function testGuild() {
        $endpoint = $this->api()->guild();

        $this->assertEndpointUrl('v2/guild', $endpoint);
    }

    public function testUpgrades() {
        $endpoint = $this->api()->guild()->upgrades();

        $this->assertEndpointUrl( 'v2/guild/upgrades', $endpoint );
        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );

        $this->mockResponse('[38,43,44,51,55]');
        $this->assertEquals( [38,43,44,51,55], $endpoint->ids() );
    }

    public function testPermissions() {
        $endpoint = $this->api()->guild()->permissions();

        $this->assertEndpointUrl( 'v2/guild/permissions', $endpoint );
        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );

        $this->mockResponse('["ClaimableEditOptions","EditBGM","ActivatePlaceables"]');
        $this->assertEquals('ClaimableEditOptions', $endpoint->ids()[0] );
    }
}
