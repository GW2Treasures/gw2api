<?php

namespace GW2Treasures\GW2Api\V2;

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
        // TODO: implement
    }
    
    /**
     * Get a single page.
     *
     * @param int $index
     * @param int $size
     * @return mixed
     */
    public function page( $index, $size = null ) {
        if( is_null( $size )) {
            $size = $this->maxPageSize();
        }

        if( $size > $this->maxPageSize() || $size <= 0 ) {
            throw new OutOfRangeException('$size has to be between 0 and ' . $this->maxPageSize() . ', was ' . $size );
        }

        if( $index < 0 ) {
            throw new OutOfRangeException('$index has to be 0 or greater');
        }

        $request = $this->createRequest(['page' => $index, 'page_size' => $size ]);
        $response = $this->request( $request );
        return $this->getResponseAsJson( $response );
    }
}
