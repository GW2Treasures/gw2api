<?php

namespace GW2Treasures\GW2Api\V2;

use GuzzleHttp\Pool;
use OutOfRangeException;

trait PaginatedEndpoint {
    use EndpointTrait;

    /**
     * Max page size of this endpoint.
     *
     * If the base class has the $maxPageSize property it will be used, otherwise defaults to 200.
     *
     * @return int
     */
    protected function maxPageSize() {
        return isset( $this->maxPageSize ) ? $this->maxPageSize : 200;
    }

    /**
     * All entries.
     *
     * @return array
     */
    public function all() {
        $size = $this->maxPageSize();
        $size = 1;

        $firstPageResponse = $this->request( $this->createPaginatedRequest( 0, $size ) );
        $total = $firstPageResponse->getHeader('X-Result-Total');

        $result = $this->getResponseAsJson( $firstPageResponse );

        if( $total <= $size ) {
            return $result;
        }

        $requests = [];
        for( $page = 1; $page < ceil( $total / $size ); $page++ ) {
            $requests[] = $this->createPaginatedRequest( $page, $size );
        }

        $responses = Pool::batch( $this->getClient(), $requests, ['pool_size' => 128]);

        foreach( $responses as $response ) {
            $result = array_merge( $result, $this->getResponseAsJson( $response ));
        }

        return $result;
    }

    /**
     * Get a single page.
     *
     * @param int $page
     * @param int $size
     * @return mixed
     */
    public function page( $page, $size = null ) {
        if( is_null( $size )) {
            $size = $this->maxPageSize();
        }

        if( $size > $this->maxPageSize() || $size <= 0 ) {
            throw new OutOfRangeException('$size has to be between 0 and ' . $this->maxPageSize() . ', was ' . $size );
        }

        if( $page < 0 ) {
            throw new OutOfRangeException('$page has to be 0 or greater');
        }

        $request = $this->createPaginatedRequest( $page, $size );
        $response = $this->request( $request );
        return $this->getResponseAsJson( $response );
    }

    protected function createPaginatedRequest( $page, $size ) {
        return $this->createRequest(['page' => $page, 'page_size' => $size ]);
    }
}
