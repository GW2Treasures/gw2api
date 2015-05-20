<?php

namespace GW2Treasures\GW2Api\V2;

use GuzzleHttp\Client;

trait EndpointTrait {
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
     * @return ApiResponse
     */
    protected abstract function request( array $query = [], $url = null, $method = 'GET', $options = [] );

    /**
     * Creates a new Request to this Endpoint.
     *
     * @param string[][] $queries
     * @param null       $url
     * @param string     $method
     * @param array      $options
     * @return ApiResponse[]
     */
    public abstract function requestMany( array $queries = [], $url = null, $method = 'GET', $options = [] );
}