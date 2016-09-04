<?php

namespace GW2Treasures\GW2Api\V2;

use GuzzleHttp\Client;
use GW2Treasures\GW2Api\GW2Api;

trait EndpointTrait {
    /**
     * @return Client
     */
    protected abstract function getClient();

    /**
     * @return GW2Api
     */
    protected abstract function getApi();

    /**
     * @return IParent
     */
    protected abstract function getParent();

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

    /**
     * Attach a ApiHandler to this endpoint.
     *
     * @param ApiHandler $handler
     */
    public abstract function attach( ApiHandler $handler );
}
