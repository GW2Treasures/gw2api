<?php

namespace GW2Treasures\GW2Api\Endpoint\V2;

use GW2Treasures\GW2Api\Endpoint\AuthenticatedEndpoint;

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
        return $this->getClient()->send( $this->createRequest() )->json([ 'object' => true ]);
    }
}
