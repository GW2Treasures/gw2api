<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Character;

use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;

class CharacterEndpoint extends AuthenticatedEndpoint implements IBulkEndpoint {
    use BulkEndpoint;

    protected $supportsIdsAll = false;

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/characters';
    }
}
