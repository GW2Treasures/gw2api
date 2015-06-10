<?php

use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use Stubs\PaginatedEndpointStub;

class PaginatedEndpointTest extends TestCase {
    protected function getPaginatedEndpoint( $maxPageSize = 10 ) {
        return new PaginatedEndpointStub( $this->api(), $maxPageSize );
    }

    public function testBasicPage() {
        $this->mockResponse('[]');

        $this->getPaginatedEndpoint()->page( 1, 2 );

        $request = $this->getLastRequest();

        $this->assertTrue( $request->getQuery()->hasKey('page'),
            'PaginatedEndpoint sets page query parameter' );
        $this->assertEquals( 1, $request->getQuery()->get('page'),
            'PaginatedEndpoint sets correct page query parameter value' );

        $this->assertTrue( $request->getQuery()->hasKey('page_size'),
            'PaginatedEndpoint sets page_size query parameter' );
        $this->assertEquals( 2, $request->getQuery()->get('page_size'),
            'PaginatedEndpoint sets correct page_size query parameter value' );
    }

    public function testAll() {
        $firstResponse = new Response(
            200,
            [ 'X-Result-Total' => 10, 'Content-Type' => 'application/json; charset=utf-8' ],
            Stream::factory( '[1,2,3]' )
        );

        $this->mockResponse( $firstResponse );
        $this->mockResponse( '[4,5,6]' );
        $this->mockResponse( '[7,8,9]' );
        $this->mockResponse( '[10]' );

        $result = $this->getPaginatedEndpoint( 3 )->all();
        $this->assertCount( 10, $result, 'PaginatedEndpoint gets all results' );

        $requests = $this->history->getRequests();
        $this->assertCount( 4, $requests, 'PaginatedEndpoint makes exactly as many requests as pages exist' );

        $this->assertEquals( 0, $requests[0]->getQuery()->get('page') );
        $this->assertEquals( 1, $requests[1]->getQuery()->get('page') );
        $this->assertEquals( 2, $requests[2]->getQuery()->get('page') );
        $this->assertEquals( 3, $requests[3]->getQuery()->get('page') );
    }

    public function testAllSmall() {
        $firstResponse = new Response(
            200,
            [ 'X-Result-Total' => 3, 'Content-Type' => 'application/json; charset=utf-8' ],
            Stream::factory( '[1,2,3]' )
        );

        $this->mockResponse( $firstResponse );

        $result = $this->getPaginatedEndpoint( 3 )->all();
        $this->assertCount( 3, $result, 'PaginatedEndpoint gets all results' );

        $requests = $this->history->getRequests();
        $this->assertCount( 1, $requests, 'PaginatedEndpoint only makes one request if all results fit in one page' );
        $this->assertEquals( 0, $requests[0]->getQuery()->get('page') );
    }

    public function testBatch() {
        $firstResponse = new Response(
            200,
            [ 'X-Result-Total' => 10, 'Content-Type' => 'application/json; charset=utf-8' ],
            Stream::factory( '[1,2,3]' )
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

        $requests = $this->history->getRequests();
        $this->assertCount( 4, $requests,
            'PaginatedEndpoint::batch makes exactly as many requests as pages exist' );

        $this->assertEquals( 0, $requests[0]->getQuery()->get('page') );
        $this->assertEquals( 1, $requests[1]->getQuery()->get('page') );
        $this->assertEquals( 2, $requests[2]->getQuery()->get('page') );
        $this->assertEquals( 3, $requests[3]->getQuery()->get('page') );
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
            Stream::factory( '{"text":"page out of range. Use page values 0 - 1."}' )
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
