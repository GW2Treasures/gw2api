<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\WvW;

use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\Localization\LocalizedEndpoint;

class MatchEndpoint extends Endpoint implements IBulkEndpoint {
    use BulkEndpoint;

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/wvw/matches';
    }
}
