<?php

namespace Stubs;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;

class AuthenticatedEndpointStub extends EndpointStub implements IAuthenticatedEndpoint {
    use AuthenticatedEndpoint;

    public function __construct( GW2Api $api, $apiKey ) {
        parent::__construct( $api );

        $this->apiKey = $apiKey;
    }
}
