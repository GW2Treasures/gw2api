<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Build;

use GW2Treasures\GW2Api\V2\Endpoint;

class BuildEndpoint extends Endpoint {

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/build';
    }

    /**
     * Get the current build id.
     *
     * @return int
     */
    public function get() {
        return $this->request()->json()->id;
    }
}
