<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Commerce;

use GW2Treasures\GW2Api\V2\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Interfaces\IBulkEndpoint;

class PriceEndpoint extends Endpoint implements IBulkEndpoint {
    use BulkEndpoint;

    /** @var bool $supportsIdsAll */
    protected $supportsIdsAll = false;

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/commerce/prices';
    }
}
