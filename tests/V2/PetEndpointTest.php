<?php

class PetEndpointTest extends TestCase {
    public function testIds() {
        $endpoint = $this->api()->pets();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsLocalized( $endpoint );
        $this->assertEndpointUrl( 'v2/pets', $endpoint );

        $this->mockResponse('{"id":1,"name":"Juvenile Jungle Stalker"}');
        $this->assertEquals('Juvenile Jungle Stalker', $endpoint->get(1)->name);
    }
}
