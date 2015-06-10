<?php

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use Stubs\EndpointStub;

class ApiExceptionTest extends TestCase {
    protected function getEndpoint() {
        return new EndpointStub( $this->api() );
    }


    /**
     * @expectedException \GW2Treasures\GW2Api\Exception\ApiException
     * @expectedExceptionMessage this is the error message.
     */
    public function testMessage() {
        $this->mockResponse( new Response(
            400, [ 'Content-Type' => 'application/json; charset=utf-8' ],
            Stream::factory( '{"text":"this is the error message."}' )
        ));

        $this->getEndpoint()->test();
    }

    public function testResponse() {
        $this->mockResponse( new Response(
            400, [ 'Content-Type' => 'application/json; charset=utf-8', 'foo' => 'bar' ],
            Stream::factory( '{"text":"this is the error message."}' )
        ));

        try {
            $this->getEndpoint()->test();
        } catch( \GW2Treasures\GW2Api\Exception\ApiException $exception ) {
            $this->assertNotNull( $exception->getResponse() );
            $this->assertEquals( 'bar', $exception->getResponse()->getHeader('foo') );
            $this->assertEquals( 400, $exception->getCode() );
            $this->assertEquals( 400, $exception->getResponse()->getStatusCode() );

            $this->assertStringStartsWith( $exception->getMessage(), $exception->__toString() );
            $this->assertNotFalse( strstr( $exception->__toString(), 'status: 400' ));
        }
    }

    /**
     * @expectedException \GW2Treasures\GW2Api\Exception\ApiException
     * @expectedExceptionMessage Unknown GW2Api error
     */
    public function testUnknownException() {
        $this->mockResponse( new Response(
            500, [], Stream::factory( 'Internal server error' )
        ));

        $this->getEndpoint()->test();
    }

    /**
     * @expectedException \GuzzleHttp\Exception\ConnectException
     * @expectedExceptionMessage RequestExceptionWithoutResponse
     */
    public function testRequestExceptionWithoutResponse() {
        $this->mockResponse(
            new ConnectException('RequestExceptionWithoutResponse', new Request('GET', 'test/exception'))
        );

        $this->getEndpoint()->test();
    }


    /**
     * @expectedException \GuzzleHttp\Exception\ConnectException
     * @expectedExceptionMessage RequestManyExceptionWithoutResponse
     */
    public function testRequestManyExceptionWithoutResponse() {
        $this->mockResponse( new Response(
            200, [ 'X-Result-Total' => 10, 'Content-Type' => 'application/json; charset=utf-8' ],
            Stream::factory( '[1,2,3]' )
        ));
        $this->mockResponse(
            new ConnectException('RequestManyExceptionWithoutResponse', new Request('GET', 'test/exception'))
        );

        $this->getEndpoint()->testMany(2);
    }
}
