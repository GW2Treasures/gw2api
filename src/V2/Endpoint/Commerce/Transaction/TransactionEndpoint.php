<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Commerce\Transaction;

use GW2Treasures\GW2Api\V2\AuthenticatedEndpoint;

class TransactionEndpoint extends AuthenticatedEndpoint {

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/commerce/transactions';
    }

    /**
     * Get current transactions.
     *
     * @return TypeEndpoint
     */
    public function current() {
        return new TypeEndpoint( $this->getApi(), $this->apiKey, 'current' );
    }

    /**
     * Get transaction history.
     *
     * @return TypeEndpoint
     */
    public function history() {
        return new TypeEndpoint( $this->getApi(), $this->apiKey, 'history' );
    }
}
