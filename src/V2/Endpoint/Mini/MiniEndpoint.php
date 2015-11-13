<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Mini;

use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\Localization\LocalizedEndpoint;

class MiniEndpoint extends Endpoint implements IBulkEndpoint, ILocalizedEndpoint {
    use BulkEndpoint, LocalizedEndpoint;

    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url() {
        return 'v2/minis';
    }
}
