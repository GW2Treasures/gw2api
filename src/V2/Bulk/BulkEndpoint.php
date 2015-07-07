<?php

namespace GW2Treasures\GW2Api\V2\Bulk;

use GW2Treasures\GW2Api\V2\Pagination\PaginatedEndpoint;

trait BulkEndpoint {
    use PaginatedEndpoint {
        PaginatedEndpoint::all as private allPaginated;
    }

    /**
     * Support of ?ids=all of this endpoint.
     *
     * If the base class the $supportsIdsAll property it will be used, otherwise defaults to true.
     *
     * @return bool
     */
    protected function supportsIdsAll() {
        return isset( $this->supportsIdsAll ) ? $this->supportsIdsAll : true;
    }

    /**
     * All ids of this BulkEndpoint.
     *
     * @return string[]|int[]
     */
    public function ids() {
        return $this->request()->json();
    }

    /**
     * Single entry by id.
     *
     * @param int|string $id
     * @return mixed
     */
    public function get( $id ) {
        return $this->request([ 'id' => $id ])->json();
    }

    /**
     * Multiple entries by ids.
     *
     * @param string[]|int[] $ids
     * @return array
     */
    public function many( array $ids = [] ) {
        if( count( $ids ) === 0 ) {
            return [];
        }

        $pages = array_chunk( $ids, $this->maxPageSize() );

        $requests = [];
        foreach( $pages as $page ) {
            $requests[] = [ 'ids' => implode( ',', $page ) ];
        }

        $responses = $this->requestMany( $requests );

        $result = [];
        foreach( $responses as $response ) {
            $result = array_merge( $result, $response->json() );
        }

        return $result;
    }

    /**
     * All entries.
     *
     * If this endpoints supports ?ids=all it will be used, otherwise it will first get all ids and then request
     * the entries with multiple requests.
     *
     * @return array
     */
    public function all() {
        if( $this->supportsIdsAll() ) {
            return $this->request([ 'ids' => 'all' ])->json();
        } else {
            return $this->allPaginated();
        }
    }
}
