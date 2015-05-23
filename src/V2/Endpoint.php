<?php

namespace GW2Treasures\GW2Api\V2;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Message\ResponseInterface;
use GuzzleHttp\Pool;
use GW2Treasures\GW2Api\Exception\ApiException;
use GW2Treasures\GW2Api\GW2Api;

abstract class Endpoint implements IEndpoint {
    /** @var GW2Api $api */
    protected $api;

    /**
     * @param GW2Api $api
     */
    public function __construct( GW2Api $api ) {
        $this->api = $api;
    }

    /**
     * @return Client
     */
    protected function getClient() {
        return $this->getApi()->getClient();
    }

    protected function getApi() {
        return $this->api;
    }

    /**
     * Creates a new Request to this Endpoint.
     *
     * @param string[] $query
     * @param null     $url
     * @param string   $method
     * @param array    $options
     * @return ApiResponse
     */
    protected function request( array $query = [], $url = null, $method = 'GET', $options = [] ) {
        $request = $this->createRequest( $query, $url, $method, $options );

        try {
            $response = $this->getClient()->send( $request );
        } catch( ClientException $ex ) {
            if( $ex->hasResponse() ) {
                $response = $ex->getResponse();
                $this->handleRequestError( $response );
            } else {
                throw $ex;
            }
        }

        return new ApiResponse( $response );
    }

    /**
     * Creates a new Request to this Endpoint.
     *
     * @param string[][] $queries
     * @param null       $url
     * @param string     $method
     * @param array      $options
     * @return ApiResponse[]
     */
    protected function requestMany( array $queries = [], $url = null, $method = 'GET', $options = [] ) {
        $requests = [];
        $responses = [];

        foreach( $queries as $query ) {
            $requests[] = $this->createRequest( $query, $url, $method, $options );
        }

        $results = Pool::batch( $this->getClient(), $requests, [ 'pool_size' => 128 ]);

        foreach( $results as $response ) {
            /** @var Response|ClientException|\Exception $response */

            if( $response instanceof \Exception ) {
                if( $response instanceof ClientException && $response->hasResponse() ) {
                    $this->handleRequestError( $response );
                }

                throw $response;
            }

            $responses[] = new ApiResponse( $response );
        }

        return $responses;
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
        return $this->getClient()->createRequest( $method, $url, $options + [ 'query' => $query ]);
    }

    /**
     * Handles response codes != 200
     *
     * @param ResponseInterface $response
     * @throws ApiException
     */
    protected function handleRequestError( ResponseInterface $response ) {
        $responseJson = $this->getResponseAsJson( $response );
        if( !is_null( $responseJson) && isset( $responseJson->text )) {
            $message = $responseJson->text;
        } else {
            $message = 'Unknown GW2Api error';
        }

        throw new ApiException( $message, $response );
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
