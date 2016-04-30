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

    public function testRecipes() {
        $endpoint = $this->api()->characters('test')->recipesOf('char');

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/characters/char/recipes', $endpoint );

        $this->mockResponse('{"recipes":[7,8,9,10,11]}');
        $this->assertEquals(7, $endpoint->get()[0]);
    }
}
