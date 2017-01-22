<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\WvW;

use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class OverviewEndpoint extends Endpoint implements IBulkEndpoint {
    use BulkEndpoint;

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/wvw/matches/overview';
    }

    /**
     * Get the current match of a world.
     *
     * @param int $id
     * @return mixed
     */
    public function world($id) {
        return $this->request(['world' => $id])->json();
    }
}
