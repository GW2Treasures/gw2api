<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Pvp;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Pagination\IPaginatedEndpoint;
use GW2Treasures\GW2Api\V2\Pagination\PaginatedEndpoint;

class LeaderboardRegionEndpoint extends Endpoint implements IPaginatedEndpoint {
    use PaginatedEndpoint;

    /** @var string $season */
    private $season;

    /** @var string $leaderboard */
    private $leaderboard;

    /** @var string $region */
    private $region;

    /**
     * @param GW2Api $api
     * @param string $season
     * @param string $leaderboard
     * @param string $region
     */
    public function __construct(GW2Api $api, $season, $leaderboard, $region) {
        parent::__construct($api);

        $this->season = $season;
        $this->leaderboard = $leaderboard;
        $this->region = $region;
    }


    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url() {
        return 'v2/pvp/seasons/'.$this->season.'/leaderboards/'.$this->leaderboard.'/'.$this->region;
    }
}
