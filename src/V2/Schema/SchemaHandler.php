<?php

namespace GW2Treasures\GW2Api\V2\Schema;

use GW2Treasures\GW2Api\V2\ApiHandler;
use GW2Treasures\GW2Api\V2\IEndpoint;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;

class SchemaHandler extends ApiHandler {
    function __construct( IEndpoint $endpoint ) {
        parent::__construct( $endpoint );
    }

    /**
     * Add the schema version header.
     *
     * @param RequestInterface $request
     *
     * @return MessageInterface|RequestInterface
     */
    public function onRequest( RequestInterface $request ) {
        $schema = $this->getEndpoint()->getSchema();

        return $request->withHeader( 'X-Schema-Version', $schema );
    }
}
