<?php

namespace GW2Treasures\GW2Api\V2\Authentication;

use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\ResponseInterface;
use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Exception\AuthenticationException;
use GW2Treasures\GW2Api\V2\Exception\InvalidPermissionsException;

abstract class AuthenticatedEndpoint extends Endpoint implements IAuthenticatedEndpoint {
    protected $apiKey;

    public function __construct( GW2Api $api, $apiKey ) {
        $this->apiKey = $apiKey;

        parent::__construct( $api );
    }

    /**
     * {@inheritdoc}
     */
    protected function createRequest( array $query = [], $url = null, $method = 'GET', $options = [] ) {
        $options = [ 'headers' => [ 'Authorization' => 'Bearer ' . $this->apiKey ]] + $options;
        return parent::createRequest( $query, $url, $method, $options );
    }

    protected function handleRequestError( ResponseInterface $response ) {
        $json = $this->getResponseAsJson( $response );
        if( !is_null( $json ) && isset( $json->text )) {
            if( $json->text === 'invalid key' ||  $json->text === 'endpoint requires authentication' ) {
                throw new AuthenticationException( $json->text, $response );
            } elseif( strpos( $json->text, 'requires scope' ) === 0 ) {
                throw new InvalidPermissionsException( $json->text, $response );
            }
        }
        parent::handleRequestError( $response );
    }
}
