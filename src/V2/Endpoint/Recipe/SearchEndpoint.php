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
        $request = $this->createRequest([ 'input' => $id ]);
        return $this->getResponseAsJson( $this->request( $request ) );
    }

    /**
     * @param int|string $id
     * @return mixed
     */
    public function output( $id ) {
        $request = $this->createRequest([ 'output' => $id ]);
        return $this->getResponseAsJson( $this->request( $request ) );
    }
}
