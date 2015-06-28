<?php

namespace V2;

use TestCase;

class AccountMaterialEndpointTest extends Testcase {
    public function test() {
        $endpoint = $this->api()->account('test')->materials();

        $this->assertEndpointIsAuthenticated( $endpoint );

        $this->mockResponse('[{"id":19699,"category":5,"count":250},{"id":19670,"category":5,"count":0}]');
        $this->assertEquals(5, $endpoint->get()[1]->category);
    }
}
