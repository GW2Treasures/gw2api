<?php

namespace GW2Treasures\GW2Api\Endpoint;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;

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
        return $this->getClient()->send( $this->createRequest() )->json();
    }

    /**
     * Single entry by id.
     *
     * @param $id
     * @return mixed
     */
    public function get( $id ) {
        $request = $this->createRequest([ 'id' => $id ]);
        $response = $this->getClient()->send( $request );
        return $response->json(['object' => true]);
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
            $requests[] = $this->createRequest( ['ids' => implode( ',', $page )] );
        }

        $responses = Pool::batch( $this->getClient(), $requests, ['pool_size' => 128] );

        $result = [];
        /** @var \GuzzleHttp\Message\Response $response */
        foreach( $responses as $response ) {
            $result = array_merge( $result, $response->json(['object' => true]) );
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
            return $this->getClient()->send( $this->createRequest([ 'ids' => 'all' ]))->json(['object' => true]);
        } else {
            $ids = $this->ids();
            return $this->many( $ids );
        }
    }

    /**
     * @return Client
     */
    protected abstract function getClient();

    /**
     * Creates a new Request to this Endpoint.
     *
     * @param string[] $query
     * @param null     $url
     * @param string   $method
     * @param array    $options
     * @return \GuzzleHttp\Message\Request|\GuzzleHttp\Message\RequestInterface
     */
    protected abstract function createRequest( array $query = [], $url = null, $method = 'GET', $options = [] );
}
