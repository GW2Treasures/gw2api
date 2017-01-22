<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Guild;

use GW2Treasures\GW2Api\V2\Endpoint;

class SearchEndpoint extends Endpoint {

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/guild/search';
    }

    /**
     * @param int $name
     * @return string[]
     */
    public function name( $name ) {
        return $this->request([ 'name' => $name ])->json();
    }
}
