<?php

namespace V2;

use TestCase;

class AccountBankEndpointTest extends Testcase {
    public function test() {
        $endpoint = $this->api()->account('test')->bank();

        $this->assertEndpointIsAuthenticated( $endpoint );

        $this->mockResponse('[null,{"id":46774,"slot":1,"count":1,"upgrades":[24675]}]');
        $this->assertEquals(24675, $endpoint->get()[1]->upgrades[0]);
    }
}
