<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Account\Mount;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class MountEndpoint extends Endpoint implements IAuthenticatedEndpoint {
    use AuthenticatedEndpoint;

    public function __construct( GW2Api $api, $apiKey ) {
        parent::__construct( $api );

        $this->apiKey = $apiKey;
    }

    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url() {
        return 'v2/account/mounts';
    }

    public function skins() {
        return new SkinEndpoint($this->api, $this->apiKey);
    }
    public function types() {
        return new TypeEndpoint($this->api, $this->apiKey);
    }
}
