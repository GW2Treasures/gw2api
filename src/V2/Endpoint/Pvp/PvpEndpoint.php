<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Pvp;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class PvpEndpoint extends Endpoint {
    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url() {
        return 'v2/pvp';
    }

    /**
     * @return AmuletEndpoint
     */
    public function amulets() {
        return new AmuletEndpoint($this->api);
    }

    /**
     * @param string $apiKey
     * @return GameEndpoint
     */
    public function games($apiKey) {
        return new GameEndpoint($this->api, $apiKey);
    }

    /**
     * @param string $apiKey
     * @return HeroEndpoint
     */
    public function heroes($apiKey) {
        return new HeroEndpoint($this->api, $apiKey);
    }

    /**
     * @return RankEndpoint
     */
    public function ranks() {
        return new RankEndpoint($this->api);
    }

    /**
     * @return SeasonEndpoint
     */
    public function seasons() {
        return new SeasonEndpoint($this->api);
    }

    /**
     * @param string $apiKey
     * @return StandingEndpoint
     */
    public function standings($apiKey) {
        return new StandingEndpoint($this->api, $apiKey);
    }

    /**
     * @param string $apiKey
     * @return StatsEndpoint
     */
    public function stats($apiKey) {
        return new StatsEndpoint($this->api, $apiKey);
    }
}
