<?php

namespace GW2Treasures\GW2Api\V2\Authentication;

use GW2Treasures\GW2Api\V2\ApiHandler;
use GW2Treasures\GW2Api\V2\Authentication\Exception\AuthenticationException;
use GW2Treasures\GW2Api\V2\Authentication\Exception\InvalidPermissionsException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @method IAuthenticatedEndpoint getEndpoint()
 */
class AuthenticationHandler extends ApiHandler {
    function __construct( IAuthenticatedEndpoint $endpoint ) {
        parent::__construct( $endpoint );
    }

    /**
     * Add the API key as Authorization header.
     *
     * @param RequestInterface $request
     *
     * @return MessageInterface|RequestInterface
     */
    public function onRequest( RequestInterface $request ) {
        $apiKey = $this->getEndpoint()->getApiKey();

        if($apiKey !== null) {
            $request = $request->withHeader( 'Authorization', 'Bearer '.$apiKey);
        }

        return $request;
    }

    /**
     * Handle invalid/wrong key and invalid permission scope errors.
     *
     * @param ResponseInterface $response
     * @param RequestInterface  $request
     *
     * @throws AuthenticationException
     * @throws InvalidPermissionsException
     */
    public function onError( ResponseInterface $response, RequestInterface $request ) {
        $json = $this->getResponseAsJson( $response );
        if( !is_null( $json ) && isset( $json->text )) {
            if( $json->text === 'invalid key' ||  $json->text === 'endpoint requires authentication' ) {
                throw new AuthenticationException( $json->text, $response );
            } elseif( preg_match('/^requires scope (.*)$/', $json->text, $match )) {
                throw new InvalidPermissionsException( $json->text, $match[1], $response );
            }
        }
    }
}
