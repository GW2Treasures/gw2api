<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Continent;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\Localization\LocalizedEndpoint;

class PoiEndpoint extends Endpoint implements IBulkEndpoint, ILocalizedEndpoint {
    use BulkEndpoint;
    use LocalizedEndpoint;

    /** @var int $continent_id */
    protected $continent_id;

    /** @var int $floor_id */
    protected $floor_id;

    /** @var int $region_id */
    protected $region_id;

    /** @var int $map_id */
    protected $map_id;

    /**
     * @param GW2Api $api
     * @param        $continent_id
     * @param        $floor_id
     * @param        $region_id
     * @param        $map_id
     */
    public function __construct( GW2Api $api, $continent_id, $floor_id, $region_id, $map_id ) {
        $this->continent_id = $continent_id;
        $this->floor_id = $floor_id;
        $this->region_id = $region_id;
        $this->map_id = $map_id;

        parent::__construct( $api );
    }

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/continents/' . $this->continent_id . '/floors/' . $this->floor_id . '/regions/' . $this->region_id . '/maps/' . $this->map_id . '/pois' ;
    }
}
