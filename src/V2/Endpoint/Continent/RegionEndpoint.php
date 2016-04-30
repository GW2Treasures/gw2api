<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Continent;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\Localization\LocalizedEndpoint;

class RegionEndpoint extends Endpoint implements IBulkEndpoint, ILocalizedEndpoint {
    use BulkEndpoint, LocalizedEndpoint;

    /** @var int $continent */
    protected $continent;

    /** @var int $floor */
    protected $floor;

    /**
     * @param GW2Api $api
     * @param int    $continent
     * @param int    $floor
     */
    public function __construct( GW2Api $api, $continent, $floor ) {
        $this->continent = $continent;
        $this->floor = $floor;

        parent::__construct( $api );
    }

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/continents/'.$this->continent.'/floors/'.$this->floor.'/regions';
    }

    /**
     * Get the regions maps.
     *
     * @param int $region
     *
     * @return MapEndpoint
     */
    public function mapsOf( $region ) {
        return new MapEndpoint( $this->api, $this->continent, $this->floor, $region );
    }
}
