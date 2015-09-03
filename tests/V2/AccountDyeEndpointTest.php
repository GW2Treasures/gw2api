<?php

namespace V2;

use TestCase;

class AccountDyeEndpointTest extends Testcase {
    public function test() {
        $endpoint = $this->api()->account('test')->dyes();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/dyes', $endpoint );

        $this->mockResponse('[8,12,13,17]');
        $this->assertEquals(8, $endpoint->get()[0]);
    }
}
