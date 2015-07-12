<?php

class TokeninfoEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->tokeninfo('api_key');

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/tokeninfo', $endpoint );

        $this->mockResponse('{
            "id": "017A2B0C-A6C5-CC4D-A055-680F427CE8FD",
            "name": "public key",
            "permissions": [
                "account",
                "characters"
            ]
        }');
        $tokeninfo = $endpoint->get();
        $this->assertEquals( 'public key', $tokeninfo->name );
        $this->assertContains( 'characters', $tokeninfo->permissions );
    }
}
