<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Account\Home;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class HomeEndpoint extends Endpoint implements IAuthenticatedEndpoint {
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
        return 'v2/account/home';
    }

    public function cats() {
        return new CatEndpoint($this->api, $this->apiKey);
    }
    public function nodes() {
        return new NodeEndpoint($this->api, $this->apiKey);
    }
}
