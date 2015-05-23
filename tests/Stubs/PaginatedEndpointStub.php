<?php

namespace Stubs;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Pagination\IPaginatedEndpoint;
use GW2Treasures\GW2Api\V2\Pagination\PaginatedEndpoint;

class PaginatedEndpointStub extends EndpointStub implements IPaginatedEndpoint {
    use PaginatedEndpoint;

    public function __construct(  GW2Api $api, $maxPageSize = 10 ) {
        parent::__construct( $api );

        $this->maxPageSize = $maxPageSize;
    }
}
