<?php

namespace GW2Treasures\GW2Api\V2;

use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\ResponseInterface;

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
            $contentType = $response->getHeader('Content-Type');
            if( stripos( $contentType, 'application/json' ) === 0 ) {
                return $response->json([ 'object' => true ]);
            }
        }

        return null;
    }

    /**
     * Modify request before it is getting send.
     *
     * @param RequestInterface $request
     */
    public function onRequest( RequestInterface $request ) { }

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
