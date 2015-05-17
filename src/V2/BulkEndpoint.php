<?php

namespace GW2Treasures\GW2Api\V2;

use GuzzleHttp\Client;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\ResponseInterface;
use GuzzleHttp\Pool;

trait BulkEndpoint {
    use PaginatedEndpoint;


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
        $response = $this->request( $this->createRequest() );
        return $this->getResponseAsJson( $response );
    }

    /**
     * Single entry by id.
     *
     * @param $id
     * @return mixed
     */
    public function get( $id ) {
        $request = $this->createRequest([ 'id' => $id ]);
        $response = $this->request( $request );
        return $this->getResponseAsJson( $response );
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
            // TODO: handle errors
            $result = array_merge( $result, $this->getResponseAsJson( $response ));
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
            $request = $this->createRequest( [ 'ids' => 'all' ] );
            $response = $this->request( $request );
            return $this->getResponseAsJson( $response );
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

    protected abstract function request( RequestInterface $request );
    protected abstract function getResponseAsJson( ResponseInterface $response );
}
