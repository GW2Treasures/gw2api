<?php

namespace GW2Treasures\GW2Api\Endpoint\V2;

use GW2Treasures\GW2Api\Endpoint\AuthenticatedEndpoint;

class CommerceTransactionEndpoint extends AuthenticatedEndpoint {

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/commerce/transactions';
    }

    /**
     * Get current transactions.
     *
     * @return CommerceTransactionListEndpoint
     */
    public function current() {
        return new CommerceTransactionListEndpoint( $this->client, $this->apiKey, 'current' );
    }

    /**
     * Get transaction history.
     *
     * @return CommerceTransactionListEndpoint
     */
    public function history() {
        return new CommerceTransactionListEndpoint( $this->client, $this->apiKey, 'history' );
    }
}
