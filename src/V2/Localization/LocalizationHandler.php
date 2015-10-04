<?php

namespace GW2Treasures\GW2Api\V2\Localization;

use GuzzleHttp\Psr7\Uri;
use GW2Treasures\GW2Api\V2\ApiHandler;
use GW2Treasures\GW2Api\V2\Localization\Exception\InvalidLanguageException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
        $localizedUri = Uri::withQueryValue( $request->getUri(), 'lang', $this->getEndpoint()->getLang() );
        return $request->withUri($localizedUri);
    }

    public function onResponse( ResponseInterface $response, RequestInterface $request ) {
        $query = $this->getQueryAsArray($request);
        $languageHeader = $response->getHeader( 'Content-Language' );

        $requestLanguage = isset($query['lang']) ? $query['lang'] : null;
        $responseLanguage = array_shift($languageHeader);

        if( $requestLanguage !== $responseLanguage) {
            $message = 'Invalid language (expected: ' . $requestLanguage . '; actual: ' . $responseLanguage . ')';
            throw new InvalidLanguageException( $message, $requestLanguage, $responseLanguage, $response );
        }
    }
}
