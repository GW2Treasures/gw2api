<?php

namespace GW2Treasures\GW2Api\V2;

use GuzzleHttp\Psr7;
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
            $typeHeader = $response->getHeader('Content-Type');
            $contentType = array_shift($typeHeader);

            if( stripos( $contentType, 'application/json' ) === 0 ) {
                return json_decode($response->getBody(), false);
            }
        }

        return null;
    }

    /**
     * Returns the parsed query string for the passed request as key-value array.
     *
     * @param RequestInterface $request
     *
     * @return array
     */
    protected function getQueryAsArray( RequestInterface $request ) {
        return Psr7\parse_query($request->getUri()->getQuery());
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
