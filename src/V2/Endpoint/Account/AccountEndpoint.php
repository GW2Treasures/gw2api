<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Account;

use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;

class AccountEndpoint extends AuthenticatedEndpoint {

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/account';
    }

    /**
     * Get your basic account info.
     *
     * @return mixed
     */
    public function info() {
        return $this->request()->json();
    }
}
