<?php

class CharacterEndpointTest extends TestCase {
    public function testIds() {
        $endpoint = $this->api()->characters('api_key');

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointUrl( 'v2/characters', $endpoint );

        $this->mockResponse('["Hello"]');
        $this->assertEquals( ['Hello'], $endpoint->ids() );
    }

    public function testGet() {
        $endpoint = $this->api()->characters('api_key');

        $this->assertEndpointUrl( 'v2/characters', $endpoint );

        $this->mockResponse('{
            "name": "Hello",
            "race": "Human",
            "gender": "Female",
            "profession": "Thief",
            "level": 80,
            "guild": "1F5F70AA-1DB6-E411-A2C4-00224D566B58"
        }');

        $character = $endpoint->get('Hello');
        $this->assertEquals( 80, $character->level );
    }

    public function testBackstory() {
        $endpoint = $this->api()->characters('test')->backstoryOf('char');

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/characters/char/backstory', $endpoint );

        $this->mockResponse('{"backstory":["26-122","27-125"]}');
        $this->assertEquals('26-122', $endpoint->get()[0]);
    }

    public function testCore() {
        $endpoint = $this->api()->characters('test')->coreOf('char');

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/characters/char/core', $endpoint );

        $this->mockResponse('{"name":"Test Char","race":"Norn","gender":"Female"}');
        $this->assertEquals('Test Char', $endpoint->get()->name);
    }

    public function testCrafting() {
        $endpoint = $this->api()->characters('test')->craftingOf('char');

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/characters/char/crafting', $endpoint );

        $this->mockResponse('{"crafting":[{"discipline":"Tailor","rating":400,"active":true}]}');
        $this->assertEquals('Tailor', $endpoint->get()[0]->discipline);
    }

    public function testHeropoints() {
        $endpoint = $this->api()->characters('test')->heropointsOf('char');

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/characters/char/heropoints', $endpoint );

        $this->mockResponse('["0-3","0-4","0-5","0-6","0-8"]');
        $this->assertEquals('0-3', $endpoint->get()[0]);
    }

    public function testRecipes() {
        $endpoint = $this->api()->characters('test')->recipesOf('char');

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/characters/char/recipes', $endpoint );

        $this->mockResponse('{"recipes":[7,8,9,10,11,12,23]}');
        $this->assertEquals([7,8,9,10,11,12,23], $endpoint->get());
    }

    public function testSab() {
        $endpoint = $this->api()->characters('test')->sabOf('char');

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/characters/char/sab', $endpoint );

        $this->mockResponse('{"zones":[{"id":1,"mode":"tribulation"}]}');
        $this->assertEquals(1, $endpoint->get()->zones[0]->id);
    }

    public function testSkills() {
        $endpoint = $this->api()->characters('test')->skillsOf('char');

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/characters/char/skills', $endpoint );

        $this->mockResponse('{"skills":{"pve":{"heal":5503,"utilities":[5641,5734,5502],"elite":5666}}}');
        $this->assertEquals(5503, $endpoint->get()->pve->heal);
    }

    public function testTraining() {
        $endpoint = $this->api()->characters('test')->trainingOf('char');

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/characters/char/training', $endpoint );

        $this->mockResponse('{"training":[{"id":111,"spent":24,"done":true}]}');
        $this->assertEquals(111, $endpoint->get()[0]->id);
    }
}
