<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Quaggan;

use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Interfaces\IBulkEndpoint;

class QuagganEndpoint extends Endpoint implements IBulkEndpoint {
    use BulkEndpoint;

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/quaggans';
    }
}
