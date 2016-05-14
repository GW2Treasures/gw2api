<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Pvp;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class StatsEndpoint extends Endpoint implements IAuthenticatedEndpoint {
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
        return 'v2/pvp/stats';
    }

    /**
     * Get pvp stats.
     * 
     * @return mixed
     */
    public function get() {
        return $this->request()->json();
    }
}
