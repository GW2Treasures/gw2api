<?php

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7;
use GW2Treasures\GW2Api\V2\Authentication\Exception\InvalidPermissionsException;
use Stubs\AuthenticatedEndpointStub;

class AuthenticatedEndpointTest extends TestCase {
    protected function getAuthenticatedEndpoint( $apiKey ) {
        return new AuthenticatedEndpointStub( $this->api(), $apiKey );
    }

    public function testBasic() {
        $this->mockResponse('[]');

        $endpoint = $this->getAuthenticatedEndpoint('test');

        $this->assertEndpointIsAuthenticated( $endpoint );

        $endpoint->test();

        $request = $this->getLastRequest();
        $this->assertHasHeader($request, 'Authorization', 'Bearer test');
    }

    /**
     * @expectedException \GW2Treasures\GW2Api\V2\Authentication\Exception\AuthenticationException
     * @expectedExceptionMessage invalid key
     */
    public function testInvalidKey() {
        $this->mockResponse( new Response(
            400, [ 'Content-Type' => 'application/json; charset=utf-8' ],
            Psr7\stream_for( '{"text":"invalid key"}' )
        ));

        $this->getAuthenticatedEndpoint('invalid')->test();
    }

    public function testInvalidPermissions() {
        $this->mockResponse( new Response(
            400, [ 'Content-Type' => 'application/json; charset=utf-8' ],
            Psr7\stream_for( '{"text":"requires scope characters"}' )
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
            Psr7\stream_for( '{"text":"unknown error"}' )
        ));

        $this->getAuthenticatedEndpoint('invalid')->test();
    }

    public function testNullKey() {
        $this->mockResponse('[]');

        $this->getAuthenticatedEndpoint(null)->test();

        $request = $this->getLastRequest();
        $this->assertHasNotHeader($request, 'Authorization');
    }
}
