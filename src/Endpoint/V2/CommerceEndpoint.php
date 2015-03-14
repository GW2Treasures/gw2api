<?php

namespace GW2Treasures\GW2Api\Endpoint\V2;

use GW2Treasures\GW2Api\Endpoint\Endpoint;

class CommerceEndpoint extends Endpoint {

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/build';
    }

    /**
     * @return CommerceExchangeEndpoint
     */
    public function exchange() {
        return new CommerceExchangeEndpoint( $this->requestManager );
    }

    /**
     * @return CommerceListingEndpoint
     */
    public function listings() {
        return new CommerceListingEndpoint( $this->requestManager );
    }

    /**
     * @return CommercePriceEndpoint
     */
    public function prices() {
        return new CommercePriceEndpoint( $this->requestManager );
    }
}
