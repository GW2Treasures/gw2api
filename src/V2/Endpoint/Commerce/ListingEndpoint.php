<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Commerce;

use GW2Treasures\GW2Api\V2\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Interfaces\IBulkEndpoint;

class ListingEndpoint extends Endpoint implements IBulkEndpoint {
    use BulkEndpoint;

    protected $supportsIdsAll = false;

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/commerce/listings';
    }
}
