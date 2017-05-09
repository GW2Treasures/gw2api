<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Account\Pvp;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class PvpEndpoint extends Endpoint implements IAuthenticatedEndpoint {
    use AuthenticatedEndpoint;

    public function __construct(GW2Api $api, $apiKey) {
        parent::__construct($api);

        $this->apiKey = $apiKey;
    }

    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url() {
        return 'v2/account/pvp';
    }

    public function heroes() {
        return new HeroEndpoint($this->api, $this->apiKey);
    }
}
