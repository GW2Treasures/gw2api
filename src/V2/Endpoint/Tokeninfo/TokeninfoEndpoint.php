<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Tokeninfo;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class TokeninfoEndpoint extends Endpoint implements IAuthenticatedEndpoint {
    use AuthenticatedEndpoint;

    public function __construct( GW2Api $api, $apiKey ) {
        parent::__construct( $api );

        $this->apiKey = $apiKey;
    }


    /**
     * @inheritdoc
     */
    public function url() {
        return 'v2/tokeninfo';
    }

    /**
     * Get info about the used api key.
     *
     * @return mixed
     */
    public function get() {
        return $this->request()->json();
    }
}
