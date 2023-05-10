<?php

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GW2Treasures\GW2Api\V2\ApiHandler;
use GW2Treasures\GW2Api\V2\IEndpoint;
use Stubs\EndpointStub;

class ApiHandlerTest extends BasicTestCase {
    protected function getEndpoint() {
        return new EndpointStub( $this->api() );
    }

    protected function getHandler( IEndpoint $endpoint ) {
        $handler = new TestHandler( $endpoint );
        $endpoint->attach( $handler );
        return $handler;
    }

    public static function makeResponse( $content, $contentType = 'application/json; charset=utf-8' ) {
        $header = !is_null( $contentType )
            ? [ 'Content-Type' => $contentType ]
            : [];

        return new Response( 200, $header, Utils::streamFor( $content ));
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
     */
    public function testRegisterNull() {
        $this->expectException(\InvalidArgumentException::class);

        $this->api()->registerHandler( null );
    }


    /**
     */
    public function testRegisterSubclassOfHandler() {
        $this->expectException(\InvalidArgumentException::class);

        $this->api()->registerHandler( 'stdClass' );
    }

    /**
     */
    public function testRegisterHandler() {
        $this->expectException(\InvalidArgumentException::class);

        $this->api()->registerHandler( $this->getHandler( $this->getEndpoint() ) );
    }

    public function testReturnCustomResponse() {
        $endpoint = $this->getEndpoint();
        $this->getHandler($endpoint);

        $this->mockResponse('{ "handler": false }');
        $response = $endpoint->test();

        $this->assertTrue( $response->handler );
    }
}

class TestHandler extends ApiHandler {
    public function responseAsJson( ResponseInterface $response ) {
        return $this->getResponseAsJson( $response );
    }

    public function queryAsArray( RequestInterface $request ) {
        return $this->getQueryAsArray($request);
    }

    public function onResponse( ResponseInterface $response, RequestInterface $request ) {
        return ApiHandlerTest::makeResponse('{ "handler": true }');
    }
}
