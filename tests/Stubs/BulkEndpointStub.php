<?php

namespace Stubs;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;

class BulkEndpointStub extends EndpointStub implements IBulkEndpoint {
    use BulkEndpoint;

    public function __construct( GW2Api $api, $supportsIdsAll, $maxPageSize ) {
        $this->supportsIdsAll = $supportsIdsAll;
        $this->maxPageSize = $maxPageSize;

        parent::__construct( $api );
    }
}
