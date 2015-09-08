<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Pvp;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class PvpEndpoint extends Endpoint implements IAuthenticatedEndpoint {
    use AuthenticatedEndpoint;

    /**
     * @param GW2Api $api
     * @param string $apiKey
     */
    public function __construct(GW2Api $api, $apiKey) {
        $this->apiKey = $apiKey;

        parent::__construct($api);
    }

    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url() {
        return 'v2/pvp';
    }

    /**
     * @return GameEndpoint
     */
    public function games() {
        return new GameEndpoint( $this->api, $this->apiKey );
    }

    /**
     * @return StatsEndpoint
     */
    public function stats() {
        return new StatsEndpoint($this->api, $this->apiKey);
    }
}
