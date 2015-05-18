<?php

namespace Stubs;

use Stub\EndpointStub;
use GW2Treasures\GW2Api\V2\Interfaces\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\LocalizedEndpoint;

class LocalizedEndpointStub extends EndpointStub implements ILocalizedEndpoint {
    use LocalizedEndpoint;

    public function get() {
        $request = $this->createRequest();
        $response = $this->request( $request );
        return $this->getResponseAsJson( $response );
    }
}
