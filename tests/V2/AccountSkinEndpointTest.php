<?php

namespace V2;

use TestCase;

class AccountSkinEndpointTest extends Testcase {
    public function test() {
        $endpoint = $this->api()->account('test')->skins();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/skins', $endpoint );

        $this->mockResponse('[1,2,3,4,5,6]');
        $this->assertEquals([1,2,3,4,5,6], $endpoint->get());
    }
}
