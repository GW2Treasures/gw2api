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
     * Get guild members.
     *
     * @param string $apiKey
     * @param string $guildId
     * @return MemberEndpoint
     */
    public function members($apiKey, $guildId) {
        return new MemberEndpoint($this->api, $apiKey, $guildId);
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
     * Get guild ranks.
     *
     * @param string $apiKey
     * @param string $guildId
     * @return RankEndpoint
     */
    public function ranks($apiKey, $guildId) {
        return new RankEndpoint($this->api, $apiKey, $guildId);
    }

    /**
     * Get guild upgrades.
     *
     * @return UpgradeEndpoint
     */
    public function upgrades() {
        return new UpgradeEndpoint($this->api);
    }

    /**
     * Get guild log.
     *
     * @param string $apiKey
     * @param string $guildId
     * @return LogEndpoint
     */
    public function log($apiKey, $guildId) {
        return new LogEndpoint($this->api, $apiKey, $guildId);
    }
}
