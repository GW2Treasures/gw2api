<?php

namespace V2;

use TestCase;

class AccountAchievementEndpointTest extends Testcase {
    public function test() {
        $endpoint = $this->api()->account('test')->achievements();

        $this->assertEndpointIsAuthenticated( $endpoint );
        $this->assertEndpointUrl( 'v2/account/achievements', $endpoint );

        $this->mockResponse('[{"id":1,"current":1,"max":1000,"done":false}]');
        $this->assertEquals(1000, $endpoint->get()[0]->max);
    }
}
