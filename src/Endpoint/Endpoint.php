<?php

namespace GW2Treasures\GW2Api\Endpoint;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\ResponseInterface;
use GW2Treasures\GW2Api\Endpoint\Exception\ApiException;

abstract class Endpoint {
    /** @var Client $client */
    protected $client;

    /** @var array $options */
    private $options;

    /**
     * @param Client $client
     * @param array  $options
     */
    public function __construct( Client $client, array $options = [] ) {
        $this->client = $client;
        $this->options = $options;
    }

    /**
     * @return Client
     */
    protected function getClient() {
        return $this->client;
    }

    /**
     * Creates a new Request to this Endpoint.
     *
     * @param string[] $query
     * @param null     $url
     * @param string   $method
     * @param array    $options
     * @return RequestInterface
     */
    protected function createRequest( array $query = [], $url = null, $method = 'GET', $options = [] ) {
        $url = !is_null( $url ) ? $url : $this->url();
        return $this->client->createRequest( $method, $url, $options + [ 'query' => $query ]);
    }

    /**
     * @param RequestInterface $request
     * @return mixed
     */
    protected function request( RequestInterface $request ) {
        try {
            $response = $this->getClient()->send( $request );
        } catch( ClientException $ex ) {
            if( $ex->hasResponse() ) {
                $response = $ex->getResponse();
                $this->handleRequestError( $ex->getRequest(), $response );
            } else {
                throw $ex;
            }
        }

        return $response;
    }

    /**
     * Handles response codes != 200
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @throws ApiException
     */
    protected function handleRequestError( RequestInterface $request, ResponseInterface $response ) {
        $responseJson = $this->getResponseAsJson( $response );
        if( !is_null( $responseJson) && isset( $response->text )) {
            $message = $response->text;
        } else {
            $message = 'Unknown GW2Api error';
        }

        throw new ApiException( $message, $request, $response );
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
     * The url of this endpoint.
     *
     * @return string
     */
    protected abstract function url();

    /**
     * String representation of this endpoint.
     *
     * @return string
     */
    function __toString() {
        return '[' . get_class( $this ) . '(' . $this->url() . ']';
    }
}
