<?php

use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use Stubs\BulkEndpointStub;

class BulkEndpointTest extends TestCase {
    protected function getBulkEndpoint( $supportsIdsAll = true, $maxPageSize = 10 ) {
        return new BulkEndpointStub( $this->api(), $supportsIdsAll, $maxPageSize );
    }

    public function testGet() {
        $this->mockResponse('{}');

        $endpoint = $this->getBulkEndpoint();
        $endpoint->get('test');

        $request = $this->getLastRequest();

        $this->assertTrue( $request->getQuery()->hasKey('id'),
            'BulkEndpoint sets ?id query parameter' );
        $this->assertEquals( 'test', $request->getQuery()->get('id'),
            'BulkEndpoint sets correct query parameter value for ?ids' );
    }

    public function testAllSupportingIdsAll() {
        $this->mockResponse('[1,2]');

        $endpoint = $this->getBulkEndpoint( true );
        $result = $endpoint->all();

        $request = $this->getLastRequest();

        $this->assertCount( 1, $this->history->getRequests(),
            'BulkEndpoint only uses one request to get all entries for endpoints supporting ?ids=all' );
        $this->assertCount( 2, $result,
            'BulkEndpoint returns all results for endpoints supporting ?ids=all' );

        $this->assertTrue( $request->getQuery()->hasKey('ids'),
            'BulkEndpoint sets ?ids query parameter for endpoints supporting ?ids=all' );
        $this->assertEquals( 'all', $request->getQuery()->get('ids'),
            'BulkEndpoint sets correct query parameter value for ?ids for endpoints supporting ?ids=all' );
    }

    public function testAllNotSupportingIdsAll() {
        $firstResponse = new Response(
            200,
            [ 'X-Result-Total' => 5, 'Content-Type' => 'application/json; charset=utf-8' ],
            Stream::factory( '[1,2,3]' )
        );
        $this->mockResponse( $firstResponse );
        $this->mockResponse( '[4,5]' );

        $endpoint = $this->getBulkEndpoint( false, 3 );
        $result = $endpoint->all();

        $this->assertCount( 5, $result, 'BulkEndpoint gets all results for endpoints not supporting ?ids=all' );

        $requests = $this->history->getRequests();
        $this->assertCount( 2, $requests, 'BulkEndpoint makes exactly as many requests as pages exist for endpoints not supporting ?ids=all' );

        $this->assertEquals( 0, $requests[0]->getQuery()->get('page') );
        $this->assertEquals( 1, $requests[1]->getQuery()->get('page') );
    }

    public function testManySimple() {
        $this->mockResponse('[1,2,3]');

        $endpoint = $this->getBulkEndpoint();
        $endpoint->many([1,2,3]);

        $request = $this->getLastRequest();

        $this->assertCount( 1, $this->history->getRequests(),
            'BulkEndpoint only uses one request to get many entries' );

        $this->assertTrue( $request->getQuery()->hasKey('ids'),
            'BulkEndpoint sets ?ids query parameter' );
        $this->assertEquals( '1,2,3', $request->getQuery()->get('ids'),
            'BulkEndpoint sets correct query parameter value for ?ids' );
    }

    public function testManyMultiple() {
        $this->mockResponse('[1,2,3]');
        $this->mockResponse('[4,5]');

        $endpoint = $this->getBulkEndpoint( true, 3 );
        $result = $endpoint->many([1,2,3,4,5]);

        $requests = $this->history->getRequests();

        $this->assertCount( 2, $requests,
            'BulkEndpoint uses minimum amount of requests to get many entries' );
        $this->assertCount( 5, $result,
            'BulkEndpoint returns all results when using many' );

        $this->assertTrue( $requests[0]->getQuery()->hasKey('ids'),
            'BulkEndpoint sets ?ids query parameter on first request' );
        $this->assertEquals( '1,2,3', $requests[0]->getQuery()->get('ids'),
            'BulkEndpoint sets correct query parameter value for ?ids on first request' );

        $this->assertTrue( $requests[1]->getQuery()->hasKey('ids'),
            'BulkEndpoint sets ?ids query parameter on second request' );
        $this->assertEquals( '4,5', $requests[1]->getQuery()->get('ids'),
            'BulkEndpoint sets correct query parameter value for ?ids on second request' );
    }

    public function testManyEmpty() {
        $this->mockResponse('[1,2,3]');

        $endpoint = $this->getBulkEndpoint( true, 3 );
        $result = $endpoint->many([]);

        $requests = $this->history->getRequests();

        $this->assertCount( 0, $requests,
            'BulkEndpoint returns instantly without making request when 0 ids were requested' );
        $this->assertEquals( [], $result,
            'BulkEndpoint returns empty result when 0 ids were requested' );
}

    /**
     * @expectedException \GW2Treasures\GW2Api\Exception\ApiException
     * @expectedExceptionMessage no such id
     */
    public function testInvalidId() {
        $this->mockResponse( new Response(
            404, [ 'Content-Type' => 'application/json; charset=utf-8' ],
            Stream::factory( '{"text":"no such id"}' )
        ));

        $this->getBulkEndpoint()->get('invalid');
    }

    /**
     * @expectedException \GW2Treasures\GW2Api\Exception\ApiException
     * @expectedExceptionMessage all ids provided are invalid
     */
    public function testInvalidIds() {
        $this->mockResponse( new Response(
            404, [ 'Content-Type' => 'application/json; charset=utf-8' ],
            Stream::factory( '{"text":"all ids provided are invalid"}' )
        ));

        $this->getBulkEndpoint()->many(['invalid']);
    }
}
