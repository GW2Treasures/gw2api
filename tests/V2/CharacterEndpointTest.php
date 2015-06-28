<?php

class CharacterEndpointTest extends TestCase {
    public function testIds() {
        $endpoint = $this->api()->characters('api_key');

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointIsBulk( $endpoint );

        $this->mockResponse('["Hello"]');
        $this->assertEquals( ['Hello'], $endpoint->ids() );
    }

    public function testGet() {
        $endpoint = $this->api()->characters('api_key');

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
}
