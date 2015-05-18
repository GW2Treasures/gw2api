<?php

namespace Stub;

use GuzzleHttp\Client;
use GW2Treasures\GW2Api\V2\Interfaces\IPaginatedEndpoint;
use GW2Treasures\GW2Api\V2\PaginatedEndpoint;

class PaginatedEndpointStub extends EndpointStub implements IPaginatedEndpoint {
    use PaginatedEndpoint;

    public function __construct(  Client $client, $maxPageSize = 10, array $options = [ ] ) {
        parent::__construct( $client, $options );

        $this->maxPageSize = $maxPageSize;
    }
}
