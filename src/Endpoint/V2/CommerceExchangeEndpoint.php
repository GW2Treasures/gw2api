<?php

namespace GW2Treasures\GW2Api\Endpoint\V2;

use GW2Treasures\GW2Api\Endpoint\Endpoint;

class CommerceExchangeEndpoint extends Endpoint {

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/commerce/prices';
    }

    /**
     * Current gem to coins exchange rate.
     *
     * @param int $quantity gems
     * @return mixed
     */
    public function gems( $quantity ) {
        return $this->requestManager->request( $this->url() . '/gems', [ 'quantity' => $quantity ])->json();
    }

    /**
     * Current coins to gems exchange rate.
     *
     * @param int $quantity coins
     * @return mixed
     */
    public function coins( $quantity ) {
        return $this->requestManager->request( $this->url() . '/coins', [ 'quantity' => $quantity ])->json();
    }
}
