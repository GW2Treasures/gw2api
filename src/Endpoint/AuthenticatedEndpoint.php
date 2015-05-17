<?php

namespace GW2Treasures\GW2Api\Endpoint;

use GuzzleHttp\Client;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\ResponseInterface;
use GW2Treasures\GW2Api\Endpoint\Exception\AuthenticationException;
use GW2Treasures\GW2Api\Endpoint\Exception\InvalidPermissionsException;

abstract class AuthenticatedEndpoint extends Endpoint {
    protected $apiKey;

    public function __construct( Client $client, $apiKey, array $options = [] ) {
        parent::__construct( $client, $options );
        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    protected function createRequest( array $query = [], $url = null, $method = 'GET', $options = [] ) {
        $options = [ 'headers' => [ 'Authorization' => 'Bearer ' . $this->apiKey ]] + $options;
        return parent::createRequest( $query, $url, $method, $options );
    }

    protected function handleRequestError( RequestInterface $request, ResponseInterface $response ) {
        $json = $this->getResponseAsJson( $response );
        if( !is_null( $json ) && isset( $json->text )) {
            if( $json->text === 'invalid key' ||  $json->text === 'endpoint requires authentication' ) {
                throw new AuthenticationException( $json->text, $request, $response );
            } elseif( strpos( $json->text, 'requires scope' ) === 0 ) {
                throw new InvalidPermissionsException( $json->text, $request, $response );
            }
        }
        parent::handleRequestError( $request, $response );
    }
}
