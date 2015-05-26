<?php

use GuzzleHttp\Message\Response;
use GuzzleHttp\Message\ResponseInterface;
use GuzzleHttp\Stream\Stream;
use GW2Treasures\GW2Api\V2\ApiHandler;
use GW2Treasures\GW2Api\V2\IEndpoint;
use Stubs\EndpointStub;

class ApiHandlerTest extends TestCase {
    protected function getEndpoint() {
        return new EndpointStub( $this->api() );
    }

    protected function getHandler( IEndpoint $endpoint ) {
        $handler = new TestHandler( $endpoint );
        $endpoint->attach( $handler );
        return $handler;
    }

    protected function makeResponse( $content, $contentType = 'application/json; charset=utf-8' ) {
        $header = !is_null( $contentType )
            ? [ 'Content-Type' => $contentType ]
            : [];

        return new Response( 200, $header, Stream::factory( $content ));
    }

    public function testAsJson() {
        $endpoint = $this->getEndpoint();
        $handler = $this->getHandler( $endpoint );

        $valid = $this->makeResponse( '{"valid":true}' );
        $this->assertTrue( $handler->responseAsJson( $valid )->valid );

        $invalidContentType = $this->makeResponse( '{"valid":false}', 'text/html' );
        $this->assertNull( $handler->responseAsJson( $invalidContentType ));

        $invalidNoContentType = $this->makeResponse( '{"valid":false}', null );
        $this->assertNull( $handler->responseAsJson( $invalidNoContentType ));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRegisterNull() {
        $this->api()->registerHandler( null );
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRegisterSubclassOfHandler() {
        $this->api()->registerHandler( new stdClass() );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRegisterHandler() {
        $this->api()->registerHandler( $this->getHandler( $this->getEndpoint() ) );
    }
}

class TestHandler extends ApiHandler {
    public function responseAsJson( ResponseInterface $response ) {
        return $this->getResponseAsJson( $response );
    }
}
