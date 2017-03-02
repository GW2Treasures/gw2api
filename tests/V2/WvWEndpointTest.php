<?php

class WvWEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->wvw();

        $this->assertEndpointUrl( 'v2/wvw', $endpoint );
    }

    public function testAbilityEndpoint() {
        $endpoint = $this->api()->wvw()->abilities();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/wvw/abilities', $endpoint );

        $this->mockResponse('[2,3,4,5,6,7,8,9,10,11,12,14,15,16,17,18,19,20,23,24]');
        $this->assertEquals( [2,3,4,5,6,7,8,9,10,11,12,14,15,16,17,18,19,20,23,24], $endpoint->ids() );
    }

    public function testObjectiveEndpoint() {
        $endpoint = $this->api()->wvw()->objectives();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/wvw/objectives', $endpoint );

        $this->mockResponse('{"id": "968-98","name": "Wurm Tunnel"}');
        $this->assertEquals( 'Wurm Tunnel', $endpoint->get('968-98')->name );
    }

    public function testMatchEndpoint() {
        $endpoint = $this->api()->wvw()->matches();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointUrl( 'v2/wvw/matches', $endpoint );

        $this->mockResponse('{"id":"2-6","scores":{"red":169331,"blue":246780,"green":216241}}');
        $this->assertEquals(169331, $endpoint->world('id')->scores->red);
        $this->assertEquals('world=id', $this->getLastRequest()->getUri()->getQuery());
    }

    public function testMatchOverviewEndpoint() {
        $endpoint = $this->api()->wvw()->matches()->overview();

        $this->assertEndpointUrl('v2/wvw/matches/overview', $endpoint);
        $this->assertEndpointIsBulk($endpoint);

        $this->mockResponse('{"id":"1-1","worlds":{"red":1008,"blue":1019,"green":1005}}');
        $this->assertEquals(1008, $endpoint->world(1008)->worlds->red);
        $this->assertEquals('world=1008', $this->getLastRequest()->getUri()->getQuery());
    }

    public function testMatchScoreEndpoint() {
        $endpoint = $this->api()->wvw()->matches()->scores();

        $this->assertEndpointUrl('v2/wvw/matches/scores', $endpoint);
        $this->assertEndpointIsBulk($endpoint);

        $this->mockResponse('{"id":"1-1","scores":{"red":169331,"blue":246780,"green":216241}}');
        $this->assertEquals(169331, $endpoint->world(1008)->scores->red);
        $this->assertEquals('world=1008', $this->getLastRequest()->getUri()->getQuery());
    }

    public function testMatchStatEndpoint() {
        $endpoint = $this->api()->wvw()->matches()->stats();

        $this->assertEndpointUrl('v2/wvw/matches/stats', $endpoint);
        $this->assertEndpointIsBulk($endpoint);

        $this->mockResponse('{"id":"1-1","deaths":{"red":7276,"blue":5922,"green":5767}}');
        $this->assertEquals(7276, $endpoint->world(1008)->deaths->red);
        $this->assertEquals('world=1008', $this->getLastRequest()->getUri()->getQuery());
    }

    public function testRankEndpoint() {
        $endpoint = $this->api()->wvw()->ranks();

        $this->assertEndpointUrl('v2/wvw/ranks', $endpoint);
        $this->assertEndpointIsBulk($endpoint);
        $this->assertEndpointIsLocalized($endpoint);

        $this->mockResponse('{"id":1,"title":"Invader","min_rank":1}');
        $this->assertEquals('Invader', $endpoint->get(1)->title);
    }

    public function testUpgradeEndpoint() {
        $endpoint = $this->api()->wvw()->upgrades();

        $this->assertEndpointUrl('v2/wvw/upgrades', $endpoint);
        $this->assertEndpointIsBulk($endpoint);
        $this->assertEndpointIsLocalized($endpoint);

        $this->mockResponse('[3,4,7,8,9]');
        $this->assertEquals([3,4,7,8,9], $endpoint->ids());
    }
}
