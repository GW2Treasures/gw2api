<?php

use GW2Treasures\GW2Api\V2\Endpoint\Pvp\GameEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Pvp\StatsEndpoint;

class PvpEndpointTest extends TestCase {
    public function testPvp() {
        $endpoint = $this->api()->pvp();

        $this->assertEndpointUrl( 'v2/pvp', $endpoint );

        $this->assertInstanceOf( GameEndpoint::class, $endpoint->games('API_KEY') );
        $this->assertInstanceOf( StatsEndpoint::class, $endpoint->stats('API_KEY') );
    }

    public function testAmulets() {
        $endpoint = $this->api()->pvp()->amulets();

        $this->assertEndpointUrl('v2/pvp/amulets', $endpoint);
        $this->assertEndpointIsBulk($endpoint);
        $this->assertEndpointIsLocalized($endpoint);

        $this->mockResponse('{"id": "4","name": "Assassin Amulet"}');
        $this->assertEquals('Assassin Amulet', $endpoint->get(4)->name);
    }

    public function testGames() {
        $endpoint = $this->api()->pvp()->games('API_KEY');

        $this->assertEndpointUrl('v2/pvp/games', $endpoint);
        $this->assertEndpointIsAuthenticated($endpoint);
        $this->assertEndpointIsBulk($endpoint);

        $this->mockResponse('["A9F9FD97-F114-4F97-B2CA-5E814DF0340E","4FDC931F-677F-4369-B20A-9FBB6A63B2B4"]');
        $this->assertContains('4FDC931F-677F-4369-B20A-9FBB6A63B2B4', $endpoint->ids());
    }

    public function testSeasons() {
        $endpoint = $this->api()->pvp()->seasons();

        $this->assertEndpointUrl('v2/pvp/seasons', $endpoint);
        $this->assertEndpointIsBulk($endpoint);
        $this->assertEndpointIsLocalized($endpoint);

        $this->mockResponse('{
            "id": "44B85826-B5ED-4890-8C77-82DDF9F2CF2B",
            "name": "PvP League Season One", 
            "start": "2015-12-01T20:00:00.000Z", 
            "end": "2016-01-28T01:00:00.000Z", 
            "active": false, 
            "divisions": []
        }');
        $this->assertEquals('PvP League Season One', $endpoint->get("44B85826-B5ED-4890-8C77-82DDF9F2CF2B")->name);
    }

    public function testStanding() {
        $endpoint = $this->api()->pvp()->standings('API_KEY');

        $this->assertEndpointUrl( 'v2/pvp/standings', $endpoint );
        $this->assertEndpointIsAuthenticated( $endpoint );

        $this->mockResponse('{
                "current" : {
                    "total_points": 101,
                    "division": 4,
                    "tier": 1
                },
                "season_id" : "ABC-123"
        }');
        $this->assertEquals(4, $endpoint->get()->current->division);
    }

    public function testStats() {
        $endpoint = $this->api()->pvp()->stats('API_KEY');

        $this->assertEndpointUrl('v2/pvp/stats', $endpoint);
        $this->assertEndpointIsAuthenticated($endpoint);

        $this->mockResponse('{"pvp_rank":57}');
        $this->assertEquals(57, $endpoint->get()->pvp_rank);
    }
}
