<?php

use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use Stubs\AuthenticatedEndpointStub;

class AuthenticatedEndpointTest extends TestCase {
    protected function getAuthenticatedEndpoint( $apiKey ) {
        return new AuthenticatedEndpointStub( $this->api(), $apiKey );
    }

    public function testBasic() {
        $this->mockResponse('[]');

        $this->getAuthenticatedEndpoint('test')->test();

        $request = $this->getLastRequest();
        $this->assertTrue( $request->hasHeader('Authorization'),
            'AuthenticatedEndpoint sets Authorization header' );
        $this->assertEquals( 'Bearer test', $request->getHeader('Authorization'),
            'AuthenticatedEndpoint sets correct Authorization header' );
    }

    /**
     * @expectedException \GW2Treasures\GW2Api\V2\Exception\AuthenticationException
     * @expectedExceptionMessage invalid key
     */
    public function testInvalidKey() {
        $this->mockResponse( new Response(
            400, [ 'Content-Type' => 'application/json; charset=utf-8' ],
            Stream::factory( '{"text":"invalid key"}' )
        ));

        $this->getAuthenticatedEndpoint('invalid')->test();
    }


    /**
     * @expectedException \GW2Treasures\GW2Api\V2\Exception\InvalidPermissionsException
     * @expectedExceptionMessage requires scope characters
     */
    public function testInvalidPermissions() {
        $this->mockResponse( new Response(
            400, [ 'Content-Type' => 'application/json; charset=utf-8' ],
            Stream::factory( '{"text":"requires scope characters"}' )
        ));

        $this->getAuthenticatedEndpoint('invalid')->test();
    }
}
