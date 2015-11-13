<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\WvW;

use GW2Treasures\GW2Api\V2\Endpoint;

class WvWEndpoint extends Endpoint {
    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/wvw';
    }

    public function matches() {
        return new MatchEndpoint( $this->api );
    }

    public function objectives() {
        return new ObjectiveEndpoint( $this->api );
    }
}
