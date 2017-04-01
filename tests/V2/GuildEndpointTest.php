<?php

use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use GW2Treasures\GW2Api\Exception\ApiException;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\Exception\GuildLeaderRequiredException;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\Exception\MembershipRequiredException;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\IRestrictedGuildEndpoint;

class GuildEndpointTest extends TestCase {
    public function testGuild() {
        $endpoint = $this->api()->guild();

        $this->assertEndpointUrl('v2/guild', $endpoint);
    }

    public function testDetails() {
        $endpoint = $this->api()->guild()->detailsOf('GUILD_ID');

        $this->assertEndpointUrl('v2/guild/GUILD_ID', $endpoint);
        $this->assertInstanceOf(IAuthenticatedEndpoint::class, $endpoint);
        $this->assertNull($endpoint->getApiKey());

        $this->mockResponse('{"id":"GUILD_ID","name":"Test Guild","tag":"API"}');
        $this->assertEquals('API', $endpoint->get()->tag);
    }

    public function testDetailsAuthenticated() {
        $endpoint = $this->api()->guild()->detailsOf('GUILD_ID', 'API_KEY');

        $this->assertEndpointUrl('v2/guild/GUILD_ID', $endpoint);
        $this->assertEndpointIsAuthenticated($endpoint);

        $this->mockResponse('{"level":42,"motd":"Test everything\n","id":"GUILD_ID","name":"Test Guild","tag":"API"}');
        $this->assertEquals('API', $endpoint->get()->tag);
    }

    public function testLog() {
        $endpoint = $this->api()->guild()->logOf('API_KEY', 'GUILD_ID');

        $this->assertEndpointUrl('v2/guild/GUILD_ID/log', $endpoint);
        $this->assertEndpointIsAuthenticated($endpoint);
        $this->assertInstanceOf(IRestrictedGuildEndpoint::class, $endpoint);

        $this->mockResponse('[{"id":1190,"time":"2015-12-10T23:58:49.106Z","type":"treasury","user":"Lawton Campbell.9413","item_id":24299,"count":150}]');
        $this->assertEquals(1190, $endpoint->get()[0]->id);
    }

    public function testLogSince() {
        $endpoint = $this->api()->guild()->logOf('API_KEY', 'GUILD_ID');

        $this->assertEndpointUrl('v2/guild/GUILD_ID/log', $endpoint);
        $this->assertEndpointIsAuthenticated($endpoint);
        $this->assertInstanceOf(IRestrictedGuildEndpoint::class, $endpoint);

        $this->mockResponse('[{"id":1190,"time":"2015-12-10T23:58:49.106Z","type":"treasury","user":"Lawton Campbell.9413","item_id":24299,"count":150}]');
        $this->assertEquals(1190, $endpoint->since(1189)[0]->id);

        $this->assertEquals('since=1189', $this->getLastRequest()->getUri()->getQuery());
    }

    public function testMembers() {
        $endpoint = $this->api()->guild()->membersOf('API_KEY', 'GUILD_ID');

        $this->assertEndpointUrl('v2/guild/GUILD_ID/members', $endpoint);
        $this->assertEndpointIsAuthenticated($endpoint);
        $this->assertInstanceOf(IRestrictedGuildEndpoint::class, $endpoint);

        $this->mockResponse('[{"name":"darthmaim.6017","rank":"Leader"}]');
        $this->assertEquals('darthmaim.6017', $endpoint->get()[0]->name);
    }

    public function testPermissions() {
        $endpoint = $this->api()->guild()->permissions();

        $this->assertEndpointUrl('v2/guild/permissions', $endpoint);
        $this->assertEndpointIsBulk($endpoint);
        $this->assertEndpointIsLocalized($endpoint);

        $this->mockResponse('["ClaimableEditOptions","EditBGM","ActivatePlaceables"]');
        $this->assertEquals('ClaimableEditOptions', $endpoint->ids()[0]);
    }

    public function testRanks() {
        $endpoint = $this->api()->guild()->ranksOf('API_KEY', 'GUILD_ID');

        $this->assertEndpointUrl('v2/guild/GUILD_ID/ranks', $endpoint);
        $this->assertEndpointIsAuthenticated($endpoint);
        $this->assertInstanceOf(IRestrictedGuildEndpoint::class, $endpoint);

        $this->mockResponse('[{"id":"Leader","order":1,"permissions":[]}]');
        $this->assertEquals('Leader', $endpoint->get()[0]->id);
    }

    public function testSearch() {
        $endpoint = $this->api()->guild()->search();

        $this->assertEndpointUrl('v2/guild/search', $endpoint);

        $this->mockResponse('["335C4BB3-5CA3-E511-80D3-E4115BD7186D"]');
        $this->assertEquals('335C4BB3-5CA3-E511-80D3-E4115BD7186D', $endpoint->name("API Test")[0]);

        $this->assertEquals('name=API%20Test', $this->getLastRequest()->getUri()->getQuery());
    }

    public function testStash() {
        $endpoint = $this->api()->guild()->stashOf('API_KEY', 'GUILD_ID');

        $this->assertEndpointUrl('v2/guild/GUILD_ID/stash', $endpoint);
        $this->assertEndpointIsAuthenticated($endpoint);
        $this->assertInstanceOf(IRestrictedGuildEndpoint::class, $endpoint);

        $this->mockResponse('[{"upgrade_id":1,"size":100,"coins":1002,"note":"stash test","inventory":[]}]');
        $this->assertEquals(100, $endpoint->get()[0]->size);
    }

    public function testTeams() {
        $endpoint = $this->api()->guild()->teamsOf('API_KEY', 'GUILD_ID');

        $this->assertEndpointUrl('v2/guild/GUILD_ID/teams', $endpoint);
        $this->assertEndpointIsAuthenticated($endpoint);
        $this->assertInstanceOf(IRestrictedGuildEndpoint::class, $endpoint);

        $this->mockResponse('[{"id":1,"members":[],"name":"ez game"}]');
        $this->assertEquals('ez game', $endpoint->get()[0]->name);
    }

    public function testTreasury() {
        $endpoint = $this->api()->guild()->treasuryOf('API_KEY', 'GUILD_ID');

        $this->assertEndpointUrl('v2/guild/GUILD_ID/treasury', $endpoint);
        $this->assertEndpointIsAuthenticated($endpoint);
        $this->assertInstanceOf(IRestrictedGuildEndpoint::class, $endpoint);

        $this->mockResponse('[{"id":123,"count":100,"needed_by":[]}]');
        $this->assertEquals(123, $endpoint->get()[0]->id);
    }

    public function testUpgrades() {
        $endpoint = $this->api()->guild()->upgrades();

        $this->assertEndpointUrl('v2/guild/upgrades', $endpoint);
        $this->assertEndpointIsBulk($endpoint);
        $this->assertEndpointIsLocalized($endpoint);

        $this->mockResponse('[38,43,44,51,55]');
        $this->assertEquals( [38,43,44,51,55], $endpoint->ids() );
    }

    public function testUpgradesOf() {
        $endpoint = $this->api()->guild()->upgradesOf('API_KEY', 'GUILD_ID');

        $this->assertEndpointUrl('v2/guild/GUILD_ID/upgrades', $endpoint);
        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertInstanceOf(IRestrictedGuildEndpoint::class, $endpoint);

        $this->mockResponse('[38,43,44,51,55]');
        $this->assertEquals( [38,43,44,51,55], $endpoint->get() );
    }

    public function testMembershipRequiredException() {
        $this->setExpectedException(MembershipRequiredException::class);

        $endpoint = $this->api()->guild()->ranksOf('API_KEY', 'GUILD_ID');

        $this->assertInstanceOf(IRestrictedGuildEndpoint::class, $endpoint);

        $this->mockResponse( new Response(
            400, [ 'Content-Type' => 'application/json; charset=utf-8' ],
            Psr7\stream_for( '{"text":"membership required"}' )
        ));

        $endpoint->get();
    }

    public function testGuildLeaderRequiredException() {
        $this->setExpectedException(GuildLeaderRequiredException::class);

        $endpoint = $this->api()->guild()->ranksOf('API_KEY', 'GUILD_ID');

        $this->assertInstanceOf(IRestrictedGuildEndpoint::class, $endpoint);

        $this->mockResponse( new Response(
            400, [ 'Content-Type' => 'application/json; charset=utf-8' ],
            Psr7\stream_for( '{"text":"access restricted to guild leaders"}' )
        ));

        $endpoint->get();
    }

    /**
     * Test that other exceptions bypass the RestrictedGuildHandler.
     */
    public function testOtherException() {
        $this->setExpectedException(ApiException::class);

        $endpoint = $this->api()->guild()->membersOf('API_KEY', 'GUILD_ID');

        $this->assertInstanceOf(IRestrictedGuildEndpoint::class, $endpoint);

        $this->mockResponse( new Response(
            400, [ 'Content-Type' => 'application/json; charset=utf-8' ],
            Psr7\stream_for( '{"text":"unknown error"}' )
        ));

        $endpoint->get();
    }
}
