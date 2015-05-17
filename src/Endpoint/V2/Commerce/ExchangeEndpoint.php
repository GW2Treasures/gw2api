<?php

namespace GW2Treasures\GW2Api\Endpoint\V2\Commerce;

use GW2Treasures\GW2Api\Endpoint\Endpoint;

class ExchangeEndpoint extends Endpoint {

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
        $request = $this->createRequest([ 'quantity' => $quantity ], $this->url() . '/gems' );
        return $this->getResponseAsJson( $this->request( $request ) );
    }

    /**
     * Current coins to gems exchange rate.
     *
     * @param int $quantity coins
     * @return mixed
     */
    public function coins( $quantity ) {
        $request = $this->createRequest([ 'quantity' => $quantity ], $this->url() . '/coins' );
        return $this->getResponseAsJson( $this->request( $request ) );
    }
}
