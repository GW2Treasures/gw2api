<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Recipe;

use GW2Treasures\GW2Api\V2\Endpoint;

class SearchEndpoint extends Endpoint {

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/recipes/search';
    }

    /**
     * @param int $id
     * @return int[]
     */
    public function input( $id ) {
        return $this->request([ 'input' => $id ])->json();
    }

    /**
     * @param int $id
     * @return int[]
     */
    public function output( $id ) {
        return $this->request([ 'output' => $id ])->json();
    }
}
