<?php

namespace GW2Treasures\GW2Api\V2;

use GuzzleHttp\Client;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\ResponseInterface;
use GW2Treasures\GW2Api\V2\Exception\AuthenticationException;
use GW2Treasures\GW2Api\V2\Exception\InvalidPermissionsException;
use GW2Treasures\GW2Api\V2\Interfaces\IAuthenticatedEndpoint;

abstract class AuthenticatedEndpoint extends Endpoint implements IAuthenticatedEndpoint {
    protected $apiKey;

    public function __construct( Client $client, $apiKey ) {
        $this->apiKey = $apiKey;

        parent::__construct( $client );
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
