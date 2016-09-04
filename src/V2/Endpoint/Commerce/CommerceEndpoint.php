<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Commerce;

use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Commerce\Transaction\TransactionEndpoint;

class CommerceEndpoint extends Endpoint {

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function url() {
        return 'v2/commerce';
    }

    /**
     * Current gem/coin exchange rates.
     *
     * @return ExchangeEndpoint
     */
    public function exchange() {
        return new ExchangeEndpoint( $this->getParent() );
    }

    /**
     * Current trading post listings.
     *
     * @return ListingEndpoint
     */
    public function listings() {
        return new ListingEndpoint( $this->getParent() );
    }

    /**
     * Current trading post prices.
     *
     * @return PriceEndpoint
     */
    public function prices() {
        return new PriceEndpoint( $this->getParent() );
    }

    /**
     * Current and completed transactions.
     *
     * @return TransactionEndpoint
     */
    public function transactions() {
        return new TransactionEndpoint( $this->getParent() );
    }
}
