<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Commerce;

use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Commerce\Transaction\TransactionEndpoint;

class CommerceEndpoint extends Endpoint {

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/commerce';
    }

    /**
     * Current gem/coin exchange rates.
     *
     * @return ExchangeEndpoint
     */
    public function exchange() {
        return new ExchangeEndpoint( $this->client );
    }

    /**
     * Current trading post listings.
     *
     * @return ListingEndpoint
     */
    public function listings() {
        return new ListingEndpoint( $this->client );
    }

    /**
     * Current trading post prices.
     *
     * @return PriceEndpoint
     */
    public function prices() {
        return new PriceEndpoint( $this->client );
    }

    /**
     * Current and completed transactions.
     *
     * @param string $apiKey
     * @return TransactionEndpoint
     */
    public function transactions( $apiKey ) {
        return new TransactionEndpoint( $this->client, $apiKey );
    }
}
