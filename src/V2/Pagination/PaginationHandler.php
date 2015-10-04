<?php

namespace GW2Treasures\GW2Api\V2\Pagination;

use GW2Treasures\GW2Api\V2\ApiHandler;
use GW2Treasures\GW2Api\V2\Pagination\Exception\PageOutOfRangeException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @method IPaginatedEndpoint getEndpoint()
 */
class PaginationHandler extends ApiHandler {
    function __construct( IPaginatedEndpoint $endpoint ) {
        parent::__construct( $endpoint );
    }

    /**
     * Handle PageOutOfRangeExceptions.
     *
     * @param ResponseInterface $response
     * @param RequestInterface  $request
     *
     * @throws PageOutOfRangeException
     */
    public function onError( ResponseInterface $response, RequestInterface $request ) {
        $json = $this->getResponseAsJson( $response );
        if( !is_null( $json ) && isset( $json->text )) {
            if( strpos( $json->text, 'page out of range.' ) === 0 ) {
                throw new PageOutOfRangeException( $json->text, $response );
            }
        }
    }
}
