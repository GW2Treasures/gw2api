<?php

namespace GW2Treasures\GW2Api\V2;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use GW2Treasures\GW2Api\Exception\ApiException;
use GW2Treasures\GW2Api\GW2Api;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class Endpoint implements IEndpoint {
    /** @var GW2Api $api */
    protected $api;

    /** @var ApiHandler[] */
    protected $handlers = [];

    /**
     * @param GW2Api $api
     */
    public function __construct( GW2Api $api ) {
        $this->api = $api;

        $this->api->attachRegisteredHandlers( $this );
    }

    /**
     * @return Client
     */
    protected function getClient() {
        return $this->getApi()->getClient();
    }

    /**
     * @return GW2Api
     */
    protected function getApi() {
        return $this->api;
    }

    /**
     * Creates a new Request to this Endpoint.
     *
     * @param string[] $query
     * @param string   $url
     * @param string   $method
     * @param array    $options
     * @return ApiResponse
     */
    protected function request( array $query = [], $url = null, $method = 'GET', $options = [] ) {
        $request = $this->createRequest( $query, $url, $method, $options );

        foreach( $this->handlers as $handler ) {
            $request = $handler->onRequest( $request );
        }

        try {
            $response = $this->getClient()->send( $request );
        } catch( RequestException $ex ) {
            if( $ex->hasResponse() ) {
                $response = $ex->getResponse();

                foreach( $this->handlers as $handler ) {
                    $handler->onError( $response, $request );
                }

                return $this->handleUnhandledError( $response );
            } else {
                throw $ex;
            }
        }

        foreach( $this->handlers as $handler ) {
            $handler->onResponse( $response, $request );
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
     * @throws ApiException
     * @throws Response
     */
    protected function requestMany( array $queries = [], $url = null, $method = 'GET', $options = [] ) {
        $requests = [];
        $responses = [];

        foreach( $queries as $query ) {
            $request = $this->createRequest( $query, $url, $method, $options );

            foreach( $this->handlers as $handler ) {
                $request = $handler->onRequest( $request );
            }

            $requests[] = $request;
        }

        $results = Pool::batch( $this->getClient(), $requests, [ 'pool_size' => 128 ]);

        foreach( $results as $i => $response ) {
            /** @var Response|RequestException|\Exception $response */

            $request = $requests[ $i ];

            if( $response instanceof \Exception ) {
                if( $response instanceof RequestException && $response->hasResponse() ) {
                    $response = $response->getResponse();

                    foreach( $this->handlers as $handler ) {
                        $handler->onError( $response, $request );
                    }

                    return $this->handleUnhandledError( $response );
                }

                throw $response;
            }

            foreach( $this->handlers as $handler ) {
                $handler->onResponse( $response, $request );
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
        $uri = new Uri($url);
        foreach ($query AS $key => $value) {
            $uri = Uri::withQueryValue($uri, $key, $value);
        }
        return new Request($method, $uri, $options);
    }

    /**
     * Handles response codes != 200.
     *
     * @param ResponseInterface $response
     * @throws ApiException
     */
    private function handleUnhandledError( ResponseInterface $response ) {
        $responseJson = null;

        if( $response->hasHeader('Content-Type') ) {
            $header_values = $response->getHeader('Content-Type');
            $contentType = array_shift($header_values);
            if( stripos( $contentType, 'application/json' ) === 0 ) {
                $responseJson = \json_decode($response->getBody());
            }
        }

        if( !is_null( $responseJson ) && isset( $responseJson->text )) {
            $message = $responseJson->text;
        } else {
            $message = 'Unknown GW2Api error';
        }

        throw new ApiException( $message, $response );
    }

    /**
     * Attach a ApiHandler to this endpoint.
     *
     * @param ApiHandler $handler
     */
    public function attach( ApiHandler $handler ) {
        $this->handlers[] = $handler;
    }

    /**
     * The url of this endpoint.
     *
     * @return string
     */
    abstract public function url();

    /**
     * String representation of this endpoint.
     *
     * @return string
     */
    function __toString() {
        return '[' . get_class( $this ) . '(' . $this->url() . ']';
    }
}
