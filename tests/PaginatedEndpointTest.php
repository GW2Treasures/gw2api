<?php

use Stub\PaginatedEndpointStub;

class PaginatedEndpointTest extends TestCase {
    protected function getPaginatedEndpoint( $maxPageSize = 10 ) {
        return new PaginatedEndpointStub( $this->api()->getClient(), $maxPageSize );
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
}
