<?php

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7;
use Stubs\PaginatedEndpointStub;

class PaginatedEndpointTest extends TestCase {
    protected function getPaginatedEndpoint( $maxPageSize = 10 ) {
        return new PaginatedEndpointStub( $this->api(), $maxPageSize );
    }

    public function testBasicPage() {
        $this->mockResponse('[]');

        $endpoint = $this->getPaginatedEndpoint();

        $this->assertEndpointIsPaginated( $endpoint );

        $endpoint->page( 1, 2 );

        $request = $this->getLastRequest();

        $this->assertHasQuery( $request, 'page', 1 );
        $this->assertHasQuery( $request, 'page_size', 2 );
    }

    public function testAll() {
        $firstResponse = new Response(
            200,
            [ 'X-Result-Total' => 10, 'Content-Type' => 'application/json; charset=utf-8' ],
            Psr7\stream_for( '[1,2,3]' )
        );

        $this->mockResponse( $firstResponse );
        $this->mockResponse( '[4,5,6]' );
        $this->mockResponse( '[7,8,9]' );
        $this->mockResponse( '[10]' );

        $result = $this->getPaginatedEndpoint( 3 )->all();
        $this->assertCount( 10, $result, 'PaginatedEndpoint gets all results' );

        $requests = $this->getRequests();
        $this->assertCount( 4, $requests, 'PaginatedEndpoint makes exactly as many requests as pages exist' );

        $this->assertHasQuery( $requests[0], 'page', 0 );
        $this->assertHasQuery( $requests[1], 'page', 1 );
        $this->assertHasQuery( $requests[2], 'page', 2 );
        $this->assertHasQuery( $requests[3], 'page', 3 );
    }

    public function testAllSmall() {
        $firstResponse = new Response(
            200,
            [ 'X-Result-Total' => 3, 'Content-Type' => 'application/json; charset=utf-8' ],
            Psr7\stream_for( '[1,2,3]' )
        );

        $this->mockResponse( $firstResponse );

        $result = $this->getPaginatedEndpoint( 3 )->all();
        $this->assertCount( 3, $result, 'PaginatedEndpoint gets all results' );

        $requests = $this->getRequests();
        $this->assertCount( 1, $requests, 'PaginatedEndpoint only makes one request if all results fit in one page' );
        $this->assertHasQuery( $requests[0], 'page', 0 );
    }

    public function testBatch() {
        $firstResponse = new Response(
            200,
            [ 'X-Result-Total' => 10, 'Content-Type' => 'application/json; charset=utf-8' ],
            Psr7\stream_for( '[1,2,3]' )
        );

        $this->mockResponse( $firstResponse );
        $this->mockResponse( '[4,5,6]' );
        $this->mockResponse( '[7,8,9]' );
        $this->mockResponse( '[10]' );

        $count = 0;
        $this->getPaginatedEndpoint( 3 )->batch(function( $entries ) use ( &$count ) {
            $count += count( $entries );
        });
        $this->assertEquals( 10, $count, 'PaginatedEndpoint gets all results' );

        $requests = $this->getRequests();
        $this->assertCount( 4, $requests,
            'PaginatedEndpoint::batch makes exactly as many requests as pages exist' );

        $this->assertHasQuery( $requests[0], 'page', 0 );
        $this->assertHasQuery( $requests[1], 'page', 1 );
        $this->assertHasQuery( $requests[2], 'page', 2 );
        $this->assertHasQuery( $requests[3], 'page', 3 );
    }


    /** @expectedException \OutOfRangeException */
    public function testPageOutOfRangeLower() {
        $this->getPaginatedEndpoint()->page( -1 );
    }

    /**
     * @expectedException GW2Treasures\GW2Api\V2\Pagination\Exception\PageOutOfRangeException
     */
    public function testPageOutOfRangeUpper() {
        $this->mockResponse( new Response(
            400, [ 'Content-Type' => 'application/json; charset=utf-8' ],
            Psr7\stream_for( '{"text":"page out of range. Use page values 0 - 1."}' )
        ));

        $this->getPaginatedEndpoint()->page( 5 );
    }

    /** @expectedException \OutOfRangeException */
    public function testPageSizeOutOfRangeLower() {
        $this->getPaginatedEndpoint()->page( 0, 0 );
    }

    /** @expectedException \OutOfRangeException */
    public function testPageSizeOutOfRangeUpper() {
        $this->getPaginatedEndpoint( 1 )->page( 0, 2 );
    }
}
