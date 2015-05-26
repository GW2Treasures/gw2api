<?php

use GuzzleHttp\Message\Response;
use GuzzleHttp\Message\ResponseInterface;
use GuzzleHttp\Stream\Stream;
use GW2Treasures\GW2Api\V2\ApiHandler;
use GW2Treasures\GW2Api\V2\IEndpoint;
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
}
