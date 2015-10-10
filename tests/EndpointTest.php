<?php

use Stubs\EndpointStub;

class EndpointTest extends TestCase {
    protected function getEndpoint() {
        return new EndpointStub( $this->api() );
    }

    public function testToString() {
        $endpoint = $this->getEndpoint();

        $string = $endpoint->__toString();

        $this->assertNotFalse( strstr( $string, 'EndpointStub' ),
            'Endpoint::toString() should contain class name');

        $this->assertNotFalse( strstr( $string, $endpoint->url() ),
            'Endpoint::toString() should contain endpoint url');

        $this->mockResponse('{}');
        $endpoint->test();

        $request = $this->getLastRequest();
        $this->assertNotNull( $request );
        $this->assertEquals( 'https://api.guildwars2.com/' . $endpoint->url(), $request->getUri() );
    }
}
