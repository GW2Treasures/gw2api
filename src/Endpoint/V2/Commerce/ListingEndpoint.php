<?php

namespace GW2Treasures\GW2Api\Endpoint\V2\Commerce;

use GW2Treasures\GW2Api\Endpoint\BulkEndpoint;
use GW2Treasures\GW2Api\Endpoint\Endpoint;

class ListingEndpoint extends Endpoint {
    use BulkEndpoint;

    protected $supportsIdsAll = false;

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/commerce/listings';
    }
}
