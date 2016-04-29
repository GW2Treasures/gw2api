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
     * Get guild log.
     *
     * @param string $apiKey
     * @param string $guildId
     * @return LogEndpoint
     */
    public function log($apiKey, $guildId) {
        return new LogEndpoint($this->api, $apiKey, $guildId);
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
     * Get guild stash.
     *
     * @param string $apiKey
     * @param string $guildId
     * @return StashEndpoint
     */
    public function stash($apiKey, $guildId) {
        return new StashEndpoint($this->api, $apiKey, $guildId);
    }

    /**
     * Get guild teams.
     *
     * @param string $apiKey
     * @param string $guildId
     * @return TeamEndpoint
     */
    public function teams($apiKey, $guildId) {
        return new TeamEndpoint($this->api, $apiKey, $guildId);
    }

    /**
     * Get guild treasury.
     *
     * @param string $apiKey
     * @param string $guildId
     * @return TreasuryEndpoint
     */
    public function treasury($apiKey, $guildId) {
        return new TreasuryEndpoint($this->api, $apiKey, $guildId);
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
