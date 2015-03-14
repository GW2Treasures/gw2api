<?php

namespace GW2Treasures\GW2Api\Endpoint\V2;

use GW2Treasures\GW2Api\Endpoint\Endpoint;
use GW2Treasures\GW2Api\Endpoint\BulkEndpoint;
use GW2Treasures\GW2Api\Endpoint\LocalizedEndpoint;

class WorldEndpoint extends Endpoint {
    use BulkEndpoint, LocalizedEndpoint;

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/worlds';
    }
}
