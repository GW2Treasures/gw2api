<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Pvp;

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
        return new AmuletEndpoint($this->parent);
    }

    /**
     * @return GameEndpoint
     */
    public function games() {
        return new GameEndpoint($this->parent);
    }

    /**
     * @return SeasonEndpoint
     */
    public function seasons() {
        return new SeasonEndpoint($this->parent);
    }

    /**
     * @return StandingEndpoint
     */
    public function standings() {
        return new StandingEndpoint($this->parent);
    }

    /**
     * @return StatsEndpoint
     */
    public function stats() {
        return new StatsEndpoint($this->parent);
    }
}
