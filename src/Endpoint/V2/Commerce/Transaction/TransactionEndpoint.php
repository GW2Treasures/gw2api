<?php

namespace GW2Treasures\GW2Api\Endpoint\V2\Commerce\Transaction;

use GW2Treasures\GW2Api\Endpoint\AuthenticatedEndpoint;

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
     * @return ListEndpoint
     */
    public function current() {
        return new ListEndpoint( $this->client, $this->apiKey, 'current' );
    }

    /**
     * Get transaction history.
     *
     * @return ListEndpoint
     */
    public function history() {
        return new ListEndpoint( $this->client, $this->apiKey, 'history' );
    }
}
