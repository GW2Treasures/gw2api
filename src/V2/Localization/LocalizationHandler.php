<?php

namespace GW2Treasures\GW2Api\V2\Localization;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GW2Treasures\GW2Api\V2\ApiHandler;
use GW2Treasures\GW2Api\V2\Localization\Exception\InvalidLanguageException;

/**
 * @method ILocalizedEndpoint getEndpoint()
 */
class LocalizationHandler extends ApiHandler {
    function __construct( ILocalizedEndpoint $endpoint ) {
        parent::__construct( $endpoint );
    }

    /**
     * Adds the `lang` query parameter to the request for localized endpoints.
     *
     * @param RequestInterface $request
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function onRequest( RequestInterface $request ) {
        $new_uri = Uri::withQueryValue( $request->getUri(), 'lang', $this->getEndpoint()->getLang() );
        return $request->withUri($new_uri);
    }

    public function onResponse( ResponseInterface $response, RequestInterface $request ) {
        $query = $this->getQueryAsArray($request);
        $header_values = $response->getHeader( 'Content-Language' );

        $requestLanguage = (isset($query['lang'])) ? $query['lang'] : NULL;
        $responseLanguage = (!empty($header_values)) ? array_shift($header_values) : NULL;

        if( $requestLanguage !== $responseLanguage) {
            $message = 'Invalid language (expected: ' . $requestLanguage . '; actual: ' . $responseLanguage . ')';
            throw new InvalidLanguageException( $message, $requestLanguage, $responseLanguage, $response );
        }
    }
}
