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

        $this->assertHasQuery( $request, 'id', 'test' );
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

        $this->assertHasQuery( $request, 'ids', 'all' );
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
        $this->assertCount( 2, $requests,
            'BulkEndpoint makes exactly as many requests as pages exist for endpoints not supporting ?ids=all' );

        $this->assertHasQuery( $requests[0], 'page', 0 );
        $this->assertHasQuery( $requests[1], 'page', 1 );
    }

    public function testManySimple() {
        $this->mockResponse('[1,2,3]');

        $endpoint = $this->getBulkEndpoint();
        $endpoint->many([1,2,3]);

        $request = $this->getLastRequest();

        $this->assertCount( 1, $this->getRequests(),
            'BulkEndpoint only uses one request to get many entries' );

        $this->assertHasQuery( $request, 'ids', '1,2,3' );
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

        $this->assertHasQuery( $requests[0], 'ids', '1,2,3' );
        $this->assertHasQuery( $requests[1], 'ids', '4,5' );
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
