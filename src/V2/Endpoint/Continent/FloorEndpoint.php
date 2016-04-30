<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Continent;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\Localization\LocalizedEndpoint;

class FloorEndpoint extends Endpoint implements IBulkEndpoint, ILocalizedEndpoint {
    use BulkEndpoint, LocalizedEndpoint;

    /** @var int $continent */
    protected $continent;

    /**
     * @param GW2Api $api
     * @param int    $continent
     */
    public function __construct( GW2Api $api, $continent ) {
        $this->continent = $continent;

        parent::__construct( $api );
    }

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/continents/'.$this->continent.'/floors';
    }

    /**
     * Get the floors regions.
     *
     * @param int $floor
     *
     * @return RegionEndpoint
     */
    public function regionsOf( $floor ) {
        return new RegionEndpoint( $this->api, $this->continent, $floor );
    }
}
