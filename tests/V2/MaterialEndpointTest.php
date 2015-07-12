<?php

namespace V2;

use TestCase;

class MaterialEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->materials();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/materials', $endpoint );

        $this->mockResponse('{"id":5,"name":"Cooking Materials","items":[12134,12238,12147]}');
        $this->assertCount(3, $endpoint->get(5)->items);
    }
}
