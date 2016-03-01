<?php

class AccountEndpointTest extends TestCase {
    public function testAccount() {
        $endpoint = $this->api()->account('api_key');

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account', $endpoint );

        $this->mockResponse('{
            "id":"account-guid",
            "name"   : "Lawton.1234",
            "world"  : 1007,
            "guilds" : [
                "DA9137CD-3A86-E411-B57A-00224D566B58",
                "1F5F70AA-1DB6-E411-A2C4-00224D566B58",
                "8B211747-3B86-E411-B57A-00224D566B58"
            ]
        }');
        $this->assertEquals( 'Lawton.1234', $endpoint->get()->name );
    }

    public function testAchievements() {
        $endpoint = $this->api()->account('test')->achievements();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/achievements', $endpoint );

        $this->mockResponse('[{"id":1,"current":1,"max":1000,"done":false}]');
        $this->assertEquals(1000, $endpoint->get()[0]->max);
    }

    public function testBank() {
        $endpoint = $this->api()->account('test')->bank();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/bank', $endpoint );

        $this->mockResponse('[null,{"id":46774,"slot":1,"count":1,"upgrades":[24675]}]');
        $this->assertEquals(24675, $endpoint->get()[1]->upgrades[0]);
    }

    public function testDyes() {
        $endpoint = $this->api()->account('test')->dyes();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/dyes', $endpoint );

        $this->mockResponse('[8,12,13,17]');
        $this->assertEquals(8, $endpoint->get()[0]);
    }

    public function testInventory() {
        $endpoint = $this->api()->account('test')->inventory();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/inventory', $endpoint );

        $this->mockResponse('[null,{"id":12138,"count":250},null]');
        $this->assertEquals(12138, $endpoint->get()[1]->id);
    }

    public function testMaterials() {
        $endpoint = $this->api()->account('test')->materials();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/materials', $endpoint );

        $this->mockResponse('[{"id":19699,"category":5,"count":250},{"id":19670,"category":5,"count":0}]');
        $this->assertEquals(5, $endpoint->get()[1]->category);
    }

    public function testMinis() {
        $endpoint = $this->api()->account('test')->minis();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/minis', $endpoint );

        $this->mockResponse('[1,2,3,4,5,6]');
        $this->assertEquals([1,2,3,4,5,6], $endpoint->get());
    }

    public function testSkins() {
        $endpoint = $this->api()->account('test')->skins();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/skins', $endpoint );

        $this->mockResponse('[1,2,3,4,5,6]');
        $this->assertEquals([1,2,3,4,5,6], $endpoint->get());
    }

    public function testWallet() {
        $endpoint = $this->api()->account('test')->wallet();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/wallet', $endpoint );

        $this->mockResponse('[{"id":1,"value":1337},{"id":2,"value":9001}]');
        $this->assertEquals(1337, $endpoint->get()[0]->value);
    }
}
