<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Guild;

use GW2Treasures\GW2Api\V2\Endpoint;

class GuildEndpoint extends Endpoint {
    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url() {
        return 'v2/guild';
    }

    public function upgrades() {
        return new UpgradeEndpoint($this->api);
    }
}
