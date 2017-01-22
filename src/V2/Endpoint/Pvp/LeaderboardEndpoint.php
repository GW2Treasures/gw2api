<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Pvp;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Endpoint;

class LeaderboardEndpoint extends Endpoint {
    /** @var string $season */
    private $season;

    /**
     * @param GW2Api $api
     * @param string $season
     */
    public function __construct(GW2Api $api, $season) {
        parent::__construct($api);
        $this->season = $season;
    }

    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url() {
        return 'v2/pvp/seasons/'.$this->season.'/leaderboards';
    }

    /**
     * Get a list of available leaderboards.
     *
     * @return string[]
     */
    public function ids() {
        return $this->request()->json();
    }

    public function get($leaderboard, $region) {
        return new LeaderboardRegionEndpoint($this->api, $this->season, $leaderboard, $region);
    }
}
