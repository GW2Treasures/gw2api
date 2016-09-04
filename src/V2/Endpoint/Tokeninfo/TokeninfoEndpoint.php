<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Tokeninfo;

use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class TokeninfoEndpoint extends Endpoint implements IAuthenticatedEndpoint {
    use AuthenticatedEndpoint;

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
