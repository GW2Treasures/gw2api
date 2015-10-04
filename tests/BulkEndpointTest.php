<?php

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7;
use Stubs\BulkEndpointStub;

class BulkEndpointTest extends TestCase {
    protected function getBulkEndpoint( $supportsIdsAll = true, $maxPageSize = 10 ) {
        return new BulkEndpointStub( $this->api(), $supportsIdsAll, $maxPageSize );
    }

    public function testGet() {
        $this->mockResponse('{}');

        $endpoint = $this->getBulkEndpoint();

        $this->assertEndpointIsBulk( $endpoint );
        $this->assertEndpointIsPaginated( $endpoint );

        $endpoint->get('test');

        $request = $this->getLastRequest();

        $query_array = $this->getQueryArray($request);
        $this->assertArrayHasKey( 'id', $query_array,
            'BulkEndpoint sets ?id query parameter' );
        $this->assertEquals( 'test', $query_array['id'],
            'BulkEndpoint sets correct query parameter value for ?ids' );
    }

    public function testAllSupportingIdsAll() {
        $this->mockResponse('[1,2]');

        $endpoint = $this->getBulkEndpoint( true );
        $result = $endpoint->all();

        $request = $this->getLastRequest();

        $this->assertCount( 1, $this->getRequests(),
            'BulkEndpoint only uses one request to get all entries for endpoints supporting ?ids=all' );
        $this->assertCount( 2, $result,
            'BulkEndpoint returns all results for endpoints supporting ?ids=all' );

        $query_array = $this->getQueryArray($request);
        $this->assertArrayHasKey( 'ids', $query_array,
            'BulkEndpoint sets ?ids query parameter for endpoints supporting ?ids=all' );
        $this->assertEquals( 'all', $query_array['ids'],
            'BulkEndpoint sets correct query parameter value for ?ids for endpoints supporting ?ids=all' );
    }

    public function testAllNotSupportingIdsAll() {
        $firstResponse = new Response(
            200,
            [ 'X-Result-Total' => 5, 'Content-Type' => 'application/json; charset=utf-8' ],
            Psr7\stream_for( '[1,2,3]' )
        );
        $this->mockResponse( $firstResponse );
        $this->mockResponse( '[4,5]' );

        $endpoint = $this->getBulkEndpoint( false, 3 );
        $result = $endpoint->all();

        $this->assertCount( 5, $result, 'BulkEndpoint gets all results for endpoints not supporting ?ids=all' );

        $requests = $this->getRequests();
        $this->assertCount( 2, $requests, 'BulkEndpoint makes exactly as many requests as pages exist for endpoints not supporting ?ids=all' );

        $query_array = $this->getQueryArray($requests[0]);
        $this->assertEquals( 0, $query_array['page'] );
        $query_array = $this->getQueryArray($requests[1]);
        $this->assertEquals( 1, $query_array['page'] );
    }

    public function testManySimple() {
        $this->mockResponse('[1,2,3]');

        $endpoint = $this->getBulkEndpoint();
        $endpoint->many([1,2,3]);

        $request = $this->getLastRequest();

        $this->assertCount( 1, $this->getRequests(),
            'BulkEndpoint only uses one request to get many entries' );

        $query_array = $this->getQueryArray($request);
        $this->assertArrayHasKey( 'ids', $query_array,
            'BulkEndpoint sets ?ids query parameter' );
        $this->assertEquals( '1,2,3', $query_array['ids'],
            'BulkEndpoint sets correct query parameter value for ?ids' );
    }

    public function testManyMultiple() {
        $this->mockResponse('[1,2,3]');
        $this->mockResponse('[4,5]');

        $endpoint = $this->getBulkEndpoint( true, 3 );
        $result = $endpoint->many([1,2,3,4,5]);

        $requests = $this->getRequests();

        $this->assertCount( 2, $requests,
            'BulkEndpoint uses minimum amount of requests to get many entries' );
        $this->assertCount( 5, $result,
            'BulkEndpoint returns all results when using many' );

        $query_array = $this->getQueryArray($requests[0]);
        $this->assertArrayHasKey( 'ids', $query_array,
            'BulkEndpoint sets ?ids query parameter on first request' );
        $this->assertEquals( '1,2,3', $query_array['ids'],
            'BulkEndpoint sets correct query parameter value for ?ids on first request' );

        $query_array = $this->getQueryArray($requests[1]);
        $this->assertArrayHasKey( 'ids', $query_array,
            'BulkEndpoint sets ?ids query parameter on second request' );
        $this->assertEquals( '4,5', $query_array['ids'],
            'BulkEndpoint sets correct query parameter value for ?ids on second request' );
    }

    public function testManyEmpty() {
        $this->mockResponse('[1,2,3]');

        $endpoint = $this->getBulkEndpoint( true, 3 );
        $result = $endpoint->many([]);

        $requests = $this->getRequests();

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
            Psr7\stream_for( '{"text":"no such id"}' )
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
            Psr7\stream_for( '{"text":"all ids provided are invalid"}' )
        ));

        $this->getBulkEndpoint()->many(['invalid']);
    }
}
