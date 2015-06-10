<?php

class TokeninfoEndpointTest extends TestCase {
    public function test() {
        $this->mockResponse('{
            "id": "017A2B0C-A6C5-CC4D-A055-680F427CE8FD",
            "name": "public key",
            "permissions": [
                "account",
                "characters"
            ]
        }');

        $tokeninfo = $this->api()->tokeninfo('api_key')->get();
        $this->assertEquals( 'public key', $tokeninfo->name );
        $this->assertContains( 'characters', $tokeninfo->permissions );
    }
}
