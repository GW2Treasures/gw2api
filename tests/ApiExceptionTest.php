<?php

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use Stubs\EndpointStub;

class ApiExceptionTest extends BasicTestCase {
    protected function getEndpoint() {
        return new EndpointStub( $this->api() );
    }

    /**
     */
    public function testMessage() {
        $this->expectException(\GW2Treasures\GW2Api\Exception\ApiException::class, 'this is the error message.');

        $this->mockResponse( new Response(
            400, [ 'Content-Type' => 'application/json; charset=utf-8' ],
            Utils::streamFor( '{"text":"this is the error message."}' )
        ));

        $this->getEndpoint()->test();
    }

    public function testResponse() {
        $endpoint = $this->getEndpoint();

        $this->mockResponse( new Response(
            400, [ 'Content-Type' => 'application/json; charset=utf-8', 'foo' => 'bar' ],
            Utils::streamFor( '{"text":"this is the error message."}' )
        ));

        try {
            $endpoint->test();
        } catch( \GW2Treasures\GW2Api\Exception\ApiException $exception ) {
            $this->assertNotNull( $exception->getResponse() );
            $this->assertHasHeader( $exception->getResponse(), 'foo', 'bar' );
            $this->assertEquals( 400, $exception->getCode() );
            $this->assertEquals( 400, $exception->getResponse()->getStatusCode() );

            $this->assertStringStartsWith( $exception->getMessage(), $exception->__toString() );
            $this->assertNotFalse( strstr( $exception->__toString(), 'status: 400' ));
            $this->assertNotFalse(
                strstr( $exception->__toString(), 'url: https://api.guildwars2.com/'. $endpoint->url() ));
        }
    }

    /**
     */
    public function testUnknownException() {
        $this->expectException(\GW2Treasures\GW2Api\Exception\ApiException::class, 'Unknown GW2Api error');

        $this->mockResponse( new Response(
            500, [], Utils::streamFor( 'Internal server error' )
        ));

        $this->getEndpoint()->test();
    }

    /**
     */
    public function testRequestExceptionWithoutResponse() {
        $this->expectException(RequestException::class, 'RequestExceptionWithoutResponse');

        $this->mockResponse(
            new RequestException('RequestExceptionWithoutResponse', new Request('GET', 'test/exception'))
        );

        $this->getEndpoint()->test();
    }


    /**
     */
    public function testRequestManyExceptionWithoutResponse() {
        $this->expectException(RequestException::class, 'RequestManyExceptionWithoutResponse');

        $this->mockResponse( new Response(
            200, [ 'X-Result-Total' => 10, 'Content-Type' => 'application/json; charset=utf-8' ],
            Utils::streamFor( '[1,2,3]' )
        ));
        $this->mockResponse(
            new RequestException('RequestManyExceptionWithoutResponse', new Request('GET', 'test/exception'))
        );

        $this->getEndpoint()->testMany(2);
    }
}
