<?php

namespace GW2Treasures\GW2Api\Endpoint\V2\Commerce;

use GW2Treasures\GW2Api\Endpoint\Endpoint;
use GW2Treasures\GW2Api\Endpoint\V2\Commerce\Transaction\TransactionEndpoint;

class CommerceEndpoint extends Endpoint {

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/commerce';
    }

    /**
     * @return ExchangeEndpoint
     */
    public function exchange() {
        return new ExchangeEndpoint( $this->client );
    }

    /**
     * @return ListingEndpoint
     */
    public function listings() {
        return new ListingEndpoint( $this->client );
    }

    /**
     * @return PriceEndpoint
     */
    public function prices() {
        return new PriceEndpoint( $this->client );
    }

    public function transactions( $apiKey ) {
        return new TransactionEndpoint( $this->client, $apiKey );
    }
}
