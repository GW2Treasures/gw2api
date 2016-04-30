<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Continent;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\Localization\LocalizedEndpoint;

class TaskEndpoint extends Endpoint implements IBulkEndpoint, ILocalizedEndpoint {
    use BulkEndpoint, LocalizedEndpoint;

    /** @var int $continent */
    protected $continent;

    /** @var int $floor */
    protected $floor;

    /** @var int $region */
    protected $region;

    /** @var int $map */
    protected $map;

    /**
     * @param GW2Api $api
     * @param int    $continent
     * @param int    $floor
     * @param int    $region
     * @param int    $map
     */
    public function __construct( GW2Api $api, $continent, $floor, $region, $map ) {
        $this->continent = $continent;
        $this->floor = $floor;
        $this->region = $region;
        $this->map = $map;

        parent::__construct( $api );
    }

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/continents/'.$this->continent.'/floors/'.$this->floor.'/regions/'.$this->region.'/maps/'.$this->map.'/tasks';
    }
}
