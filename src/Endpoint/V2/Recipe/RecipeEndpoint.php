<?php

namespace GW2Treasures\GW2Api\Endpoint\V2\Recipe;

use GW2Treasures\GW2Api\Endpoint\BulkEndpoint;
use GW2Treasures\GW2Api\Endpoint\Endpoint;

class RecipeEndpoint extends Endpoint {
    use BulkEndpoint;

    /** @var bool $supportsIdsAll */
    protected $supportsIdsAll = false;

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/recipes';
    }

    /**
     * @return SearchEndpoint
     */
    public function search() {
        return new SearchEndpoint( $this->client );
    }
}
