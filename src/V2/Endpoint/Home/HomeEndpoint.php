<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Home;

use GW2Treasures\GW2Api\V2\Endpoint;

class HomeEndpoint extends Endpoint {
    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/home';
    }

    public function cats() {
        return new CatEndpoint( $this->api );
    }

    public function nodes() {
        return new NodeEndpoint( $this->api );
    }
}
