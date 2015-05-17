<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Color;

use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\BulkEndpoint;
use GW2Treasures\GW2Api\V2\LocalizedEndpoint;

class ColorEndpoint extends Endpoint {
    use BulkEndpoint, LocalizedEndpoint;

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/colors';
    }
}
