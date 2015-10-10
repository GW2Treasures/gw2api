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
        $header_values = $firstPageResponse->getResponse()->getHeader('X-Result-Total');
        $total = array_shift($header_values);

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
     * Get all entries in multiple small batches.
     *
     * @param int|null $parallelRequests [optional]
     * @param callable $callback
     * @return void
     */
    public function batch( $parallelRequests = null, callable $callback = null ) {
        /** @noinspection PhpParamsInspection */
        if( !isset( $callback ) && is_callable( $parallelRequests )) {
            $callback = $parallelRequests;
            $parallelRequests = null;
        }

        if( is_null( $parallelRequests )) {
            $parallelRequests = 6;
        }

        $size = $this->maxPageSize();

        $firstPageResponse = $this->request( $this->createPaginatedRequestQuery( 0, $size ) );
        $header_values = $firstPageResponse->getResponse()->getHeader('X-Result-Total');
        $total = array_shift($header_values);

        call_user_func( $callback, $firstPageResponse->json() );
        unset( $firstPageResponse );

        $lastPage = ceil( $total / $size );

        for( $page = 1; $page < $lastPage; ) {
            $batchRequests = [];

            for( $batchPage = 0; $batchPage < $parallelRequests && $page + $batchPage < $lastPage; $batchPage++ ) {
                $batchRequests[] = $this->createPaginatedRequestQuery( $page + $batchPage, $size );
            }

            $responses = $this->requestMany( $batchRequests );

            foreach( $responses as $response ) {
                call_user_func( $callback, $response->json() );
            }

            unset( $responses );

            $page += $parallelRequests;
        }
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
