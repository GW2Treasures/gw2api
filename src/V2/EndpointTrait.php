<?php

namespace GW2Treasures\GW2Api\V2;

use GuzzleHttp\Client;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\ResponseInterface;

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
     * @return \GuzzleHttp\Message\Request|\GuzzleHttp\Message\RequestInterface
     */
    protected abstract function createRequest( array $query = [], $url = null, $method = 'GET', $options = [] );

    protected abstract function request( RequestInterface $request );

    protected abstract function getResponseAsJson( ResponseInterface $response );
}
