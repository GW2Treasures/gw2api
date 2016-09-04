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
     * Get log of a guild.
     *
     * @param string $guildId
     * @return LogEndpoint
     */
    public function logOf($guildId) {
        return new LogEndpoint($this->parent, $guildId);
    }

    /**
     * Get members of a guild.
     *
     * @param string $guildId
     * @return MemberEndpoint
     */
    public function membersOf($guildId) {
        return new MemberEndpoint($this->parent, $guildId);
    }

    /**
     * Get guild permissions.
     *
     * @return PermissionEndpoint
     */
    public function permissions() {
        return new PermissionEndpoint($this->parent);
    }

    /**
     * Get ranks of a guild.
     *
     * @param string $guildId
     * @return RankEndpoint
     */
    public function ranksOf($guildId) {
        return new RankEndpoint($this->parent, $guildId);
    }

    /**
     * Get stash of a guild.
     *
     * @param string $guildId
     * @return StashEndpoint
     */
    public function stashOf($guildId) {
        return new StashEndpoint($this->parent, $guildId);
    }

    /**
     * Get teams of a guild.
     *
     * @param string $guildId
     * @return TeamEndpoint
     */
    public function teamsOf($guildId) {
        return new TeamEndpoint($this->parent, $guildId);
    }

    /**
     * Get treasury of a guild.
     *
     * @param string $guildId
     * @return TreasuryEndpoint
     */
    public function treasuryOf($guildId) {
        return new TreasuryEndpoint($this->parent, $guildId);
    }

    /**
     * Get upgrades of a guild.
     *
     * @param string $guildId
     * @return AuthenticatedUpgradeEndpoint
     */
    public function upgradesOf($guildId) {
        return new AuthenticatedUpgradeEndpoint($this->parent, $guildId);
    }

    /**
     * Get guild upgrades.
     *
     * @return UpgradeEndpoint
     */
    public function upgrades() {
        return new UpgradeEndpoint($this->parent);
    }
}
