<?php

namespace GW2Treasures\GW2Api\Endpoint;

use GW2Treasures\GW2Api\Request\Response;

trait BulkEndpoint {

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
     * @param $id
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

        $queries = [];
        foreach( $pages as $page ) {
            $queries[] = ['ids' => implode( ',', $page )];
        }

        $result = [];
        $responses = $this->requestMany( $queries );
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
            return $this->request(['ids' => 'all'])->json();
        } else {
            $ids = $this->ids();
            return $this->many( $ids );
        }
    }

    /**
     * Implemented by GW2Treasures\GW2Api\Endpoint\Endpoint.
     *
     * @param string[] $query
     * @return Response
     */
    protected abstract function request( array $query = [] );

    /**
     * Implemented by GW2Treasures\GW2Api\Endpoint\Endpoint.
     *
     * @param string[][] $queries
     * @return \GW2Treasures\GW2Api\Request\Response[]
     */
    protected abstract function requestMany( array $queries );
}
