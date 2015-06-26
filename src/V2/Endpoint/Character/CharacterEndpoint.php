<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Character;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\BulkEndpoint;
use GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class CharacterEndpoint extends Endpoint implements IAuthenticatedEndpoint, IBulkEndpoint {
    use BulkEndpoint, AuthenticatedEndpoint;

    /** @var bool $supportsIdsAll */
    protected $supportsIdsAll = false;

    public function __construct( GW2Api $api, $apiKey ) {
        parent::__construct( $api );

        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    protected function url() {
        return 'v2/characters';
    }

    /**
     * Get the equipment of a character.
     *
     * @param string $character
     * @return EquipmentEndpoint
     */
    public function equipment( $character ) {
        return new EquipmentEndpoint( $this->api, $this->apiKey, $character );
    }

    /**
     * Get the inventory of a character.
     *
     * @param string $character
     * @return InventoryEndpoint
     */
    public function inventory( $character ) {
        return new InventoryEndpoint( $this->api, $this->apiKey, $character );
    }
}
