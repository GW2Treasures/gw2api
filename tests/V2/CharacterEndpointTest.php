<?php

class CharacterEndpointTest extends TestCase {
    public function testIds() {
        $this->mockResponse('["Hello"]');

        $this->assertEquals( ['Hello'], $this->api()->characters('api_key')->ids() );
    }

    public function testGet() {
        $this->mockResponse('{
            "name": "Hello",
            "race": "Human",
            "gender": "Female",
            "profession": "Thief",
            "level": 80,
            "guild": "1F5F70AA-1DB6-E411-A2C4-00224D566B58"
        }');

        $character = $this->api()->characters('api_key')->get('Hello');
        $this->assertEquals( 80, $character->level );
    }
}
