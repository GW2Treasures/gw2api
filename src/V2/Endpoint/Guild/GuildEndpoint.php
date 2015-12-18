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

    /**
     * Get guild permissions.
     *
     * @return PermissionEndpoint
     */
    public function permissions() {
        return new PermissionEndpoint($this->api);
    }

    /**
     * Get guild upgrades.
     *
     * @return UpgradeEndpoint
     */
    public function upgrades() {
        return new UpgradeEndpoint($this->api);
    }
}
