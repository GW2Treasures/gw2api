<?php

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7;
use GW2Treasures\GW2Api\V2\Authentication\Exception\InvalidPermissionsException;
use Stubs\AuthenticatedEndpointStub;
use Stubs\EndpointStub;

class AuthenticatedEndpointTest extends TestCase {
    protected function getAuthenticatedEndpoint( $apiKey ) {
        return (new AuthenticatedEndpointStub($this->api()))->auth($apiKey);
    }

    public function testBasic() {
        $this->mockResponse('[]');

        $endpoint = $this->getAuthenticatedEndpoint('test');

        $this->assertEndpointIsAuthenticated( $endpoint, 'test' );

        $endpoint->test();

        $request = $this->getLastRequest();
        $this->assertHasHeader($request, 'Authorization', 'Bearer test');
    }

    public function testUnauthorized() {
        $api = new \GW2Treasures\GW2Api\GW2Api();
        $this->assertNull($api->getApiKey());

        $endpoint = new AuthenticatedEndpointStub($api);
        $this->assertNull($endpoint->getApiKey());
    }

    public function testInheritance() {
        $this->api()->auth('API_KEY_INHERITANCE');
        $endpoint = $this->getAuthenticatedEndpoint('API_KEY_INHERITANCE');

        $this->assertEndpointIsAuthenticated($endpoint, 'API_KEY_INHERITANCE');
    }

    public function testDeepInheritance() {
        $this->api()->auth('API_KEY_BASE');

        $endpoint1 = new AuthenticatedEndpointStub($this->api());
        $endpoint2 = new AuthenticatedEndpointStub($endpoint1);

        $this->assertEndpointIsAuthenticated($endpoint1, 'API_KEY_BASE');
        $this->assertEndpointIsAuthenticated($endpoint2, 'API_KEY_BASE');

        $endpoint2->auth('API_KEY_OVERRIDE');

        $this->assertEndpointIsAuthenticated($endpoint1, 'API_KEY_BASE');
        $this->assertEndpointIsAuthenticated($endpoint2, 'API_KEY_OVERRIDE');
    }

    public function testSiblings() {
        $this->api()->auth('API_KEY_BASE');
        $endpoint1 = new AuthenticatedEndpointStub($this->api());
        $endpoint2 = new AuthenticatedEndpointStub($this->api());

        $this->assertEquals('API_KEY_BASE', $endpoint1->getApiKey());
        $this->assertEquals('API_KEY_BASE', $endpoint2->getApiKey());

        $endpoint1->auth('API_KEY_SIBLING');

        $this->assertEquals('API_KEY_SIBLING', $endpoint1->getApiKey());
        $this->assertEquals('API_KEY_BASE', $endpoint2->getApiKey());
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
}
