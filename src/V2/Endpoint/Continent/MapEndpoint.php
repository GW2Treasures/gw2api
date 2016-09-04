<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Continent;

use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\IParent;
use GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint;
use GW2Treasures\GW2Api\V2\Localization\LocalizedEndpoint;

class MapEndpoint extends Endpoint implements IBulkEndpoint, ILocalizedEndpoint {
    use BulkEndpoint, LocalizedEndpoint;

    /** @var int $continent */
    protected $continent;

    /** @var int $floor */
    protected $floor;

    /** @var int $region */
    protected $region;

    /**
     * @param IParent $parent
     * @param int    $continent
     * @param int    $floor
     * @param int    $region
     */
    public function __construct( IParent $parent, $continent, $floor, $region ) {
        $this->continent = $continent;
        $this->floor = $floor;
        $this->region = $region;

        parent::__construct( $parent );
    }

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/continents/'.$this->continent.'/floors/'.$this->floor.'/regions/'.$this->region.'/maps';
    }

    /**
     * Get the maps points of interest.
     *
     * @param int $map
     *
     * @return PoiEndpoint
     */
    public function poisOf( $map ) {
        return new PoiEndpoint( $this->parent, $this->continent, $this->floor, $this->region, $map );
    }

    /**
     * Get the maps tasks.
     *
     * @param int $map
     *
     * @return TaskEndpoint
     */
    public function tasksOf( $map ) {
        return new TaskEndpoint( $this->parent, $this->continent, $this->floor, $this->region, $map );
    }

    /**
     * Get the maps sectors.
     *
     * @param int $map
     *
     * @return SectorEndpoint
     */
    public function sectorsOf( $map ) {
        return new SectorEndpoint( $this->parent, $this->continent, $this->floor, $this->region, $map );
    }
}
