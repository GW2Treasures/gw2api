<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Continent;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\Localization\LocalizedEndpoint;

class MapEndpoint extends Endpoint implements IBulkEndpoint, ILocalizedEndpoint {
    use BulkEndpoint;
    use LocalizedEndpoint;

    /** @var int $continent_id */
    protected $continent_id;

    /** @var int $floor_id */
    protected $floor_id;

    /** @var int $region_id */
    protected $region_id;

    /**
     * @param GW2Api $api
     * @param        $continent_id
     * @param        $floor_id
     * @param        $region_id
     */
    public function __construct( GW2Api $api, $continent_id, $floor_id, $region_id ) {
        $this->continent_id = $continent_id;
        $this->floor_id = $floor_id;
        $this->region_id = $region_id;

        parent::__construct( $api );
    }

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/continents/' . $this->continent_id . '/floors/' . $this->floor_id . '/regions/' . $this->region_id . '/maps';
    }

    /**
     * Get the  map poi.
     *
     * @param $map_id
     *
     * @return PoiEndpoint
     */
    public function poi( $map_id ) {
        return new PoiEndpoint( $this->api, $this->continent_id, $this->floor_id, $this->region_id, $map_id );
    }

    /**
     * Get the  map task.
     *
     * @param $map_id
     *
     * @return TaskEndpoint
     */
    public function task( $map_id ) {
        return new TaskEndpoint( $this->api, $this->continent_id, $this->floor_id, $this->region_id, $map_id );
    }

    /**
     * Get the  map sector.
     *
     * @param $map_id
     *
     * @return SectorEndpoint
     */
    public function sector( $map_id ) {
        return new SectorEndpoint( $this->api, $this->continent_id, $this->floor_id, $this->region_id, $map_id );
    }
}
