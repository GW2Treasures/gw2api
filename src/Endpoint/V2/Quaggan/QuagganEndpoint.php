<?php

namespace GW2Treasures\GW2Api\Endpoint\V2\Quaggan;

use GW2Treasures\GW2Api\Endpoint\Endpoint;
use GW2Treasures\GW2Api\Endpoint\BulkEndpoint;

class QuagganEndpoint extends Endpoint {
    use BulkEndpoint;

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/quaggans';
    }
}
