<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Account;

use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class MaterialEndpoint extends Endpoint implements IAuthenticatedEndpoint {
    use AuthenticatedEndpoint;

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/account/materials';
    }

    public function get() {
        return $this->request()->json();
    }
}
