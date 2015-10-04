<?php

namespace GW2Treasures\GW2Api\V2;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class ApiHandler {
    /** @var IEndpoint $endpoint */
    protected $endpoint;

    function __construct( $endpoint ) {
        $this->endpoint = $endpoint;
    }

    /**
     * Get the underlying endpoint that gets handled by this handler.
     *
     * @return IEndpoint
     */
    protected function getEndpoint() {
        return $this->endpoint;
    }

    /**
     * Returns the json object if the response contains valid json, otherwise null.
     *
     * @param ResponseInterface $response
     * @return mixed|null
     */
    protected function getResponseAsJson( ResponseInterface $response ) {
        if( $response->hasHeader('Content-Type') ) {
            $header_values = $response->getHeader('Content-Type');
            $contentType = array_shift($header_values);
            if( stripos( $contentType, 'application/json' ) === 0 ) {
                return \json_decode($response->getBody(), FALSE);
            }
        }

        return null;
    }

    /**
     * Returns the parsed query string for the passed request as key-value array.
     *
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return array
     */
    protected function getQueryAsArray( RequestInterface $request ) {
        $query = $request->getUri()->getQuery();
        $pairs = explode('&', $query);
        $query_array = [];
        foreach ($pairs AS $pair) {
            if (empty($pair)) {
                continue;
            }
            list($key, $value) = explode('=', $pair);
            $query_array[$key] = $value;
        }
        return $query_array;
    }

    /**
     * Return an updated request that should be send.
     *
     * @param RequestInterface $request
     *
     * @return RequestInterface
     */
    public function onRequest( RequestInterface $request ) {
      return $request;
    }

    /**
     * Modify response before it gets processed.
     *
     * @param ResponseInterface $response
     * @param RequestInterface  $request
     */
    public function onResponse( ResponseInterface $response, RequestInterface $request ) { }

    /**
     * Handle errors by the api.
     *
     * @param ResponseInterface $response
     * @param RequestInterface  $request
     */
    public function onError( ResponseInterface $response, RequestInterface $request ) { }
}
