<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Guild;

use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\Authenticated\LogEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\Authenticated\MemberEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\Authenticated\RankEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\Authenticated\StashEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\Authenticated\TeamEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\Authenticated\TreasuryEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\Authenticated\UpgradeEndpoint as AuthenticatedUpgradeEndpoint;

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
     * Get the guild details of a guild.
     *
     * @param string $guildId
     * @param string|null $apiKey
     * @return DetailsEndpoint
     */
    public function detailsOf($guildId, $apiKey = null) {
        return new DetailsEndpoint($this->api, $guildId, $apiKey);
    }

    /**
     * Get log of a guild.
     *
     * @param string $apiKey
     * @param string $guildId
     * @return LogEndpoint
     */
    public function logOf($apiKey, $guildId) {
        return new LogEndpoint($this->api, $apiKey, $guildId);
    }

    /**
     * Get members of a guild.
     *
     * @param string $apiKey
     * @param string $guildId
     * @return MemberEndpoint
     */
    public function membersOf($apiKey, $guildId) {
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
     * Get ranks of a guild.
     *
     * @param string $apiKey
     * @param string $guildId
     * @return RankEndpoint
     */
    public function ranksOf($apiKey, $guildId) {
        return new RankEndpoint($this->api, $apiKey, $guildId);
    }

    /**
     * Search for a guild.
     *
     * @return SearchEndpoint
     */
    public function search() {
        return new SearchEndpoint($this->api);
    }

    /**
     * Get stash of a guild.
     *
     * @param string $apiKey
     * @param string $guildId
     * @return StashEndpoint
     */
    public function stashOf($apiKey, $guildId) {
        return new StashEndpoint($this->api, $apiKey, $guildId);
    }

    /**
     * Get teams of a guild.
     *
     * @param string $apiKey
     * @param string $guildId
     * @return TeamEndpoint
     */
    public function teamsOf($apiKey, $guildId) {
        return new TeamEndpoint($this->api, $apiKey, $guildId);
    }

    /**
     * Get treasury of a guild.
     *
     * @param string $apiKey
     * @param string $guildId
     * @return TreasuryEndpoint
     */
    public function treasuryOf($apiKey, $guildId) {
        return new TreasuryEndpoint($this->api, $apiKey, $guildId);
    }

    /**
     * Get upgrades of a guild.
     *
     * @param string $apiKey
     * @param string $guildId
     * @return AuthenticatedUpgradeEndpoint
     */
    public function upgradesOf($apiKey, $guildId) {
        return new AuthenticatedUpgradeEndpoint($this->api, $apiKey, $guildId);
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
