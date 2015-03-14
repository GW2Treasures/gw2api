<?php

namespace GW2Treasures\GW2Api\Endpoint\V2;

use GW2Treasures\GW2Api\Endpoint\BulkEndpoint;
use GW2Treasures\GW2Api\Endpoint\Endpoint;

class RecipeSearchEndpoint extends Endpoint {

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
