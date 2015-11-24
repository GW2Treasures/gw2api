<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Emblem;

use GW2Treasures\GW2Api\V2\Endpoint;

class EmblemEndpoint extends Endpoint {

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/emblem';
    }

    /**
     * Get background layers.
     *
     * @return LayerEndpoint
     */
    public function backgrounds() {
        return new LayerEndpoint($this->api, LayerEndpoint::TYPE_BACKGROUNDS);
    }

    /**
     * Get foregrounds layers.
     *
     * @return LayerEndpoint
     */
    public function foregrounds() {
        return new LayerEndpoint($this->api, LayerEndpoint::TYPE_FOREGROUNDS);
    }
}
