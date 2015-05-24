<?php

namespace GW2Treasures\GW2Api\V2\Pagination;

use GW2Treasures\GW2Api\V2\EndpointTrait;
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

        $firstPageResponse = $this->request( $this->createPaginatedRequestQuery( 0, $size ) );
        $total = $firstPageResponse->getResponse()->getHeader('X-Result-Total');

        $result = $firstPageResponse->json();

        if( $total <= $size ) {
            return $result;
        }

        $requests = [];
        for( $page = 1; $page < ceil( $total / $size ); $page++ ) {
            $requests[] = $this->createPaginatedRequestQuery( $page, $size );
        }

        $responses = $this->requestMany( $requests );

        foreach( $responses as $response ) {
            $result = array_merge( $result, $response->json() );
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

        return $this->request( $this->createPaginatedRequestQuery( $page, $size ) )->json();
    }

    /**
     * Creates the query parameters used for pagination.
     *
     * @param int $page
     * @param int $size
     * @return string[]
     */
    protected function createPaginatedRequestQuery( $page, $size ) {
        return ['page' => $page, 'page_size' => $size ];
    }
}
