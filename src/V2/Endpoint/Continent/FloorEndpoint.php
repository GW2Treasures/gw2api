<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Continent;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class FloorEndpoint extends Endpoint implements IBulkEndpoint {
    use BulkEndpoint;

    /** @var int $continent_id */
    protected $continent_id;

    /**
     * @param GW2Api $api
     * @param int    $continent_id
     */
    public function __construct( GW2Api $api, $continent_id ) {
        $this->continent_id = $continent_id;

        parent::__construct( $api );
    }

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/continents/' . $this->continent_id . '/floors';
    }
}
