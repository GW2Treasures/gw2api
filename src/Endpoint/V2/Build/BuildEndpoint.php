<?php

namespace GW2Treasures\GW2Api\Endpoint\V2\Build;

use GW2Treasures\GW2Api\Endpoint\Endpoint;

class BuildEndpoint extends Endpoint {

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/build';
    }

    /**
     * Get the current build id.
     *
     * @return int
     */
    public function get() {
        return $this->getResponseAsJson( $this->request( $this->createRequest() ) )->id;
    }
}
