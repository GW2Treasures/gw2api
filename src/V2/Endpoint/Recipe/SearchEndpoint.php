<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Recipe;

use GW2Treasures\GW2Api\V2\Endpoint;

class SearchEndpoint extends Endpoint {

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/recipes/search';
    }

    /**
     * @param int|string $id
     * @return mixed
     */
    public function input( $id ) {
        return $this->request([ 'input' => $id ])->json();
    }

    /**
     * @param int|string $id
     * @return mixed
     */
    public function output( $id ) {
        return $this->request([ 'output' => $id ])->json();
    }
}
