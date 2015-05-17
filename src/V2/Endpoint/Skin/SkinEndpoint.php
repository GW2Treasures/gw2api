<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Skin;

use GW2Treasures\GW2Api\V2\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Interfaces\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Interfaces\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\LocalizedEndpoint;

class SkinEndpoint extends Endpoint implements IBulkEndpoint, ILocalizedEndpoint {
    use BulkEndpoint, LocalizedEndpoint;

    /** @var bool $supportsIdsAll */
    protected $supportsIdsAll = false;

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/skins';
    }
}
