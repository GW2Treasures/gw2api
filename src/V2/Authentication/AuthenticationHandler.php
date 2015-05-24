<?php

namespace GW2Treasures\GW2Api\V2\Authentication;

use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\ResponseInterface;
use GW2Treasures\GW2Api\V2\ApiHandler;
use GW2Treasures\GW2Api\V2\Exception\AuthenticationException;
use GW2Treasures\GW2Api\V2\Exception\InvalidPermissionsException;

class AuthenticationHandler extends ApiHandler {
    function __construct( IAuthenticatedEndpoint $endpoint ) {
        parent::__construct( $endpoint );
    }

    /**
     * {@inheritdoc}
     *
     * @return IAuthenticatedEndpoint
     */
    protected function getEndpoint() {
        return parent::getEndpoint();
    }


    /**
     * Add the API key as Authorization header.
     *
     * @param RequestInterface $request
     */
    public function onRequest( RequestInterface $request ) {
        $request->addHeader( 'Authorization', 'Bearer ' . $this->getEndpoint()->getApiKey() );
    }

    /**
     * Handle invalid/wrong key and invalid permission scope errors.
     *
     * @param ResponseInterface $response
     * @throws AuthenticationException
     * @throws InvalidPermissionsException
     */
    public function onError( ResponseInterface $response = null ) {
        if( is_null( $response )) {
            return;
        }

        $json = $this->getResponseAsJson( $response );
        if( !is_null( $json ) && isset( $json->text )) {
            if( $json->text === 'invalid key' ||  $json->text === 'endpoint requires authentication' ) {
                throw new AuthenticationException( $json->text, $response );
            } elseif( strpos( $json->text, 'requires scope' ) === 0 ) {
                throw new InvalidPermissionsException( $json->text, $response );
            }
        }
    }
}
