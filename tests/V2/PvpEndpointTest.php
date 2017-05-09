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

    public function testHeroes() {
        $endpoint = $this->api()->pvp()->heroes('API_KEY');

        $this->assertEndpointUrl('v2/pvp/heroes', $endpoint);
        $this->assertEndpointIsBulk($endpoint);

        $this->mockResponse('{"id":"115C140F-C2F5-40EB-8EA2-C3773F2AE468","name":"Nika"}');
        $this->assertContains('Nika', $endpoint->get('115C140F-C2F5-40EB-8EA2-C3773F2AE468')->name);
    }

    public function testRanks() {
        $endpoint = $this->api()->pvp()->ranks();

        $this->assertEndpointUrl('v2/pvp/ranks', $endpoint);
        $this->assertEndpointIsBulk($endpoint);
        $this->assertEndpointIsLocalized($endpoint);

        $this->mockResponse('[1,2,3,4,5,6,7,8,9]');
        $this->assertEquals([1,2,3,4,5,6,7,8,9], $endpoint->ids());
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

    public function testSeasonLeaderboardsList() {
        $endpoint = $this->api()->pvp()->seasons()->leaderboardsOf('44B85826-B5ED-4890-8C77-82DDF9F2CF2B');

        $this->assertEndpointUrl('v2/pvp/seasons/44B85826-B5ED-4890-8C77-82DDF9F2CF2B/leaderboards', $endpoint);

        $this->mockResponse('["legendary","guild"]');
        $this->assertEquals('legendary', $endpoint->ids()[0]);
    }

    public function testSeasonLeaderboardsGet() {
        $endpoint = $this->api()->pvp()->seasons()->leaderboardsOf('44B85826-B5ED-4890-8C77-82DDF9F2CF2B')
            ->get('legendary', 'na');

        $this->assertEndpointUrl('v2/pvp/seasons/44B85826-B5ED-4890-8C77-82DDF9F2CF2B/leaderboards/legendary/na', $endpoint);
        $this->assertEndpointIsPaginated($endpoint);

        $this->mockResponse('[{"name":"darthmaim.6017", "rank":1}]');
        $this->assertEquals('darthmaim.6017', $endpoint->page(0, 1)[0]->name);
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
