<?php

namespace GW2Treasures\GW2Api\Endpoint\V2;

use GW2Treasures\GW2Api\Endpoint\Endpoint;

class CommerceEndpoint extends Endpoint {

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/commerce';
    }

    /**
     * @return CommerceExchangeEndpoint
     */
    public function exchange() {
        return new CommerceExchangeEndpoint( $this->client );
    }

    /**
     * @return CommerceListingEndpoint
     */
    public function listings() {
        return new CommerceListingEndpoint( $this->client );
    }

    /**
     * @return CommercePriceEndpoint
     */
    public function prices() {
        return new CommercePriceEndpoint( $this->client );
    }

    public function transactions( $apiKey ) {
        return new CommerceTransactionEndpoint( $this->client, $apiKey );
    }
}
