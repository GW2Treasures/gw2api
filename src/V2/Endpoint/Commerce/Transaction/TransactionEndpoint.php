<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Commerce\Transaction;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class TransactionEndpoint extends Endpoint implements IAuthenticatedEndpoint {
    use AuthenticatedEndpoint;

    public function __construct( GW2Api $api, $apiKey ) {
        parent::__construct( $api );

        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function url() {
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
