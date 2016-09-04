<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Emblem;

use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\IParent;

class LayerEndpoint extends Endpoint implements IBulkEndpoint {
    use BulkEndpoint;

    const TYPE_BACKGROUNDS = 'backgrounds';
    const TYPE_FOREGROUNDS = 'foregrounds';

    /**
     * @var string[] $types valid types for this endpoint.
     */
    protected static $types = [
        self::TYPE_BACKGROUNDS,
        self::TYPE_FOREGROUNDS
    ];

    /** @var string Type of this endpoint (one of self::$types) */
    protected $type;

    /**
     * @param IParent $parent
     * @param string $type Type of this endpoint.
     */
    public function __construct(IParent $parent, $type) {
        parent::__construct($parent);

        if( !in_array($type, self::$types) ) {
            throw new \InvalidArgumentException('$type has to be one of '.implode(', ', self::$types));
        }

        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/emblem/'.$this->type;
    }
}
