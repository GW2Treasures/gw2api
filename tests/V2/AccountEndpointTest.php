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
        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointUrl( 'v2/account/achievements', $endpoint );

        $this->mockResponse('[{"id":1,"current":1,"max":1000,"done":false}]');
        $this->assertEquals(1000, $endpoint->get()[0]->max);

        $this->mockResponse('{"id":1,"current":1,"max":1000,"done":false}');
        $this->assertEquals(1, $endpoint->get(1)->id);
    }

    /** @expectedException Exception */
    public function testAchievementsIds() {
        $endpoint = $this->api()->account('test')->achievements();

        /** @noinspection PhpDeprecationInspection */
        $endpoint->ids();
    }

    public function testBank() {
        $endpoint = $this->api()->account('test')->bank();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/bank', $endpoint );

        $this->mockResponse('[null,{"id":46774,"slot":1,"count":1,"upgrades":[24675]}]');
        $this->assertEquals(24675, $endpoint->get()[1]->upgrades[0]);
    }

    public function testDungeon() {
        $endpoint = $this->api()->account('test')->dungeons();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/dungeons', $endpoint );

        $this->mockResponse('[]');
        $this->assertEquals([], $endpoint->get());
    }

    public function testDyes() {
        $endpoint = $this->api()->account('test')->dyes();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/dyes', $endpoint );

        $this->mockResponse('[8,12,13,17]');
        $this->assertEquals(8, $endpoint->get()[0]);
    }

    public function testFinishers() {
        $endpoint = $this->api()->account('test')->finishers();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/finishers', $endpoint );

        $this->mockResponse('[{"id":1,"permanent":true}]');
        $this->assertEquals(true, $endpoint->get()[0]->permanent);
    }

    public function testGliders() {
        $endpoint = $this->api()->account('test')->gliders();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/gliders', $endpoint );

        $this->mockResponse('[1,2,3]');
        $this->assertEquals([1,2,3], $endpoint->get());
    }


    public function testHome() {
        $endpoint = $this->api()->account('test')->home();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/home', $endpoint );
    }

    public function testHomeCat() {
        $endpoint = $this->api()->account('test')->home()->cats();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/home/cats', $endpoint );

        $this->mockResponse('[{"id": 1,"hint": "chicken"}]');
        $this->assertEquals('chicken', $endpoint->get()[0]->hint);
    }

    public function testHomeNodes() {
        $endpoint = $this->api()->account('test')->home()->nodes();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/home/nodes', $endpoint );

        $this->mockResponse('["quartz_node","sprocket_generator"]');
        $this->assertEquals(["quartz_node","sprocket_generator"], $endpoint->get());
    }

    public function testInventory() {
        $endpoint = $this->api()->account('test')->inventory();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/inventory', $endpoint );

        $this->mockResponse('[null,{"id":12138,"count":250},null]');
        $this->assertEquals(12138, $endpoint->get()[1]->id);
    }

    public function testMailcarriers() {
        $endpoint = $this->api()->account('test')->mailcarriers();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/mailcarriers', $endpoint );

        $this->mockResponse('[15,4]');
        $this->assertEquals([15,4], $endpoint->get());
    }

    public function testMasteries() {
        $endpoint = $this->api()->account('test')->masteries();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/masteries', $endpoint );

        $this->mockResponse('[{"id":4,"level":4}]');
        $this->assertEquals(4, $endpoint->get()[0]->id);
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

    public function testOutfits() {
        $endpoint = $this->api()->account('test')->outfits();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/outfits', $endpoint );

        $this->mockResponse('[1,2,3]');
        $this->assertEquals([1,2,3], $endpoint->get());
    }

    public function testPvp() {
        $endpoint = $this->api()->account('test')->pvp();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/pvp', $endpoint );
    }

    public function testPvpHeroes() {
        $endpoint = $this->api()->account('test')->pvp()->heroes();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/pvp/heroes', $endpoint );

        $this->mockResponse('[3]');
        $this->assertEquals([3], $endpoint->get());
    }

    public function testRaids() {
        $endpoint = $this->api()->account('test')->raids();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/raids', $endpoint );

        $this->mockResponse('[]');
        $this->assertEquals([], $endpoint->get());
    }

    public function testRecipes() {
        $endpoint = $this->api()->account('test')->recipes();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/recipes', $endpoint );

        $this->mockResponse('[104,105,106,107,108,109,110,113,114]');
        $this->assertEquals([104,105,106,107,108,109,110,113,114], $endpoint->get());
    }

    public function testSkins() {
        $endpoint = $this->api()->account('test')->skins();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/skins', $endpoint );

        $this->mockResponse('[1,2,3,4,5,6]');
        $this->assertEquals([1,2,3,4,5,6], $endpoint->get());
    }

    public function testTitles() {
        $endpoint = $this->api()->account('test')->titles();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/titles', $endpoint );

        $this->mockResponse('[1,17,188,189,190,191,217]');
        $this->assertEquals([1,17,188,189,190,191,217], $endpoint->get());
    }

    public function testWallet() {
        $endpoint = $this->api()->account('test')->wallet();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/wallet', $endpoint );

        $this->mockResponse('[{"id":1,"value":1337},{"id":2,"value":9001}]');
        $this->assertEquals(1337, $endpoint->get()[0]->value);
    }
}
