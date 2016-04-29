<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Continent;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\Localization\LocalizedEndpoint;

class RegionEndpoint extends Endpoint implements IBulkEndpoint, ILocalizedEndpoint {
    use BulkEndpoint;
    use LocalizedEndpoint;

    /** @var int $continent_id */
    protected $continent_id;

    /** @var int $floor_id */
    protected $floor_id;

    /**
     * @param GW2Api $api
     * @param        $continent_id
     * @param        $floor_id
     */
    public function __construct( GW2Api $api, $continent_id, $floor_id ) {
        $this->continent_id = $continent_id;
        $this->floor_id = $floor_id;

        parent::__construct( $api );
    }

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/continents/' . $this->continent_id . '/floors/' . $this->floor_id .'/regions';
    }

    /**
     * Get the  region map.
     *
     * @param $region_id
     *
     * @return MapEndpoint
     */
    public function map( $region_id ) {
        return new MapEndpoint( $this->api, $this->continent_id, $this->floor_id, $region_id );
    }
}
