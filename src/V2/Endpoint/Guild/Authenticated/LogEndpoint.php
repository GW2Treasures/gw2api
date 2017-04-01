<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Guild\Authenticated;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\IRestrictedGuildEndpoint;

class LogEndpoint extends Endpoint implements IAuthenticatedEndpoint, IRestrictedGuildEndpoint {
    use AuthenticatedEndpoint;

    /** @var string $guildId */
    protected $guildId;

    public function __construct(GW2Api $api, $apiKey, $guildId) {
        parent::__construct($api);

        $this->apiKey = $apiKey;
        $this->guildId = $guildId;
    }

    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url() {
        return 'v2/guild/'.$this->guildId.'/log';
    }

    /**
     * Get log entries.
     *
     * @return array
     */
    public function get() {
        return $this->request()->json();
    }

    /**
     * Get log entries newer than `$lastId`.
     *
     * @param int $lastId
     * @return array
     */
    public function since($lastId) {
        return $this->request(['since' => $lastId])->json();
    }
}
