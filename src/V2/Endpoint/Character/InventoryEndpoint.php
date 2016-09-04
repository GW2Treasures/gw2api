<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Character;

use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\IParent;

class InventoryEndpoint extends Endpoint implements IAuthenticatedEndpoint {
    use AuthenticatedEndpoint;

    protected $character;

    public function __construct( IParent $parent, $character ) {
        parent::__construct( $parent );

        $this->character = $character;
    }

    /**
     * {@inheritdoc}
     */
    public function url() {
        return 'v2/characters/' . rawurlencode( $this->character ) . '/inventory';
    }

    /**
     * @return array
     */
    public function get() {
        return $this->request()->json()->bags;
    }
}
