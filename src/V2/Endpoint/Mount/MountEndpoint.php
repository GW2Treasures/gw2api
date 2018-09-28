<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Mount;

use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\Localization\LocalizedEndpoint;

class MountEndpoint extends Endpoint {
    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/mounts';
    }

    public function types() {
        return new TypeEndpoint( $this->api );
    }

    public function skins() {
        return new SkinEndpoint( $this->api );
    }
}
