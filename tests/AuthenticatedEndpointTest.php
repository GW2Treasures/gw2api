<?php

use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GW2Treasures\GW2Api\V2\Authentication\Exception\InvalidPermissionsException;
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
     * @expectedException \GW2Treasures\GW2Api\V2\Authentication\Exception\AuthenticationException
     * @expectedExceptionMessage invalid key
     */
    public function testInvalidKey() {
        $this->mockResponse( new Response(
            400, [ 'Content-Type' => 'application/json; charset=utf-8' ],
            Stream::factory( '{"text":"invalid key"}' )
        ));

        $this->getAuthenticatedEndpoint('invalid')->test();
    }

    public function testInvalidPermissions() {
        $this->mockResponse( new Response(
            400, [ 'Content-Type' => 'application/json; charset=utf-8' ],
            Stream::factory( '{"text":"requires scope characters"}' )
        ));

        try {
            $this->getAuthenticatedEndpoint('invalid')->test();
        } catch( InvalidPermissionsException $ex ) {
            $this->assertEquals( 'requires scope characters', $ex->getMessage(),
                'InvalidPermissionsException has correct error message.' );
            $this->assertEquals( 'characters', $ex->getMissingScope(),
                'InvalidPermissionsException has correct missing scope' );

            return;
        }

        $this->fail('Accessing IAuthenticatedEndpoint with an api_key that is missing scopes throws InvalidPermissionsException');
    }

    /**
     * @expectedException \GW2Treasures\GW2Api\Exception\ApiException
     * @expectedExceptionMessage unknown error
     */
    public function testUnknownError() {
        $this->mockResponse( new Response(
            400, [ 'Content-Type' => 'application/json; charset=utf-8' ],
            Stream::factory( '{"text":"unknown error"}' )
        ));

        $this->getAuthenticatedEndpoint('invalid')->test();
    }
}
