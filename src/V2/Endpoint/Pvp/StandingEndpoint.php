<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Pvp;

use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class StandingEndpoint extends Endpoint implements IAuthenticatedEndpoint {
    use AuthenticatedEndpoint;

    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url() {
        return 'v2/pvp/standings';
    }

    /**
     * Get your standing pvp info.
     *
     * @return mixed
     */
    public function get() {
        return $this->request()->json();
    }
}
