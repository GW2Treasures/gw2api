<?php

namespace V2;

use TestCase;

class AccountWalletEndpointTest extends Testcase {
    public function test() {
        $endpoint = $this->api()->account('test')->wallet();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/wallet', $endpoint );

        $this->mockResponse('[{"id":1,"value":1337},{"id":2,"value":9001}]');
        $this->assertEquals(1337, $endpoint->get()[0]->value);
    }
}
