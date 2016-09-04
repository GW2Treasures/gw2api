<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Guild\Authenticated;

use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\IRestrictedGuildEndpoint;
use GW2Treasures\GW2Api\V2\IParent;

class LogEndpoint extends Endpoint implements IAuthenticatedEndpoint, IRestrictedGuildEndpoint {
    use AuthenticatedEndpoint;

    /** @var string $guildId */
    protected $guildId;

    public function __construct(IParent $parent, $guildId) {
        parent::__construct($parent);

        $this->guildId = $guildId;
    }

    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url() {
        return 'v2/guild/'.$this->guildId.'/log';
    }

    /**
     * @return array
     */
    public function get() {
        return $this->request()->json();
    }
}
