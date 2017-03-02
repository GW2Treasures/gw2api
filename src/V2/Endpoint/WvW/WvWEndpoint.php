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

    public function abilities() {
        return new AbilityEndpoint( $this->api );
    }

    public function matches() {
        return new MatchEndpoint( $this->api );
    }

    public function objectives() {
        return new ObjectiveEndpoint( $this->api );
    }

    public function ranks() {
        return new RankEndpoint( $this->api );
    }

    public function upgrades() {
        return new UpgradeEndpoint( $this->api );
    }
}
