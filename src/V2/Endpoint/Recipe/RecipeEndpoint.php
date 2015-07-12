<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Recipe;

use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class RecipeEndpoint extends Endpoint implements IBulkEndpoint {
    use BulkEndpoint;

    /** @var bool $supportsIdsAll */
    protected $supportsIdsAll = false;

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/recipes';
    }

    /**
     * @return SearchEndpoint
     */
    public function search() {
        return new SearchEndpoint( $this->getApi() );
    }
}
