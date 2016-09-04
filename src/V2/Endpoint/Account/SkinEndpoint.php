<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Account;

use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class SkinEndpoint extends Endpoint implements IAuthenticatedEndpoint {
    use AuthenticatedEndpoint;

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/account/skins';
    }

    public function get() {
        return $this->request()->json();
    }
}
