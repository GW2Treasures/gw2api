<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Guild;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint;

class DetailsEndpoint extends Endpoint implements IAuthenticatedEndpoint {
    use AuthenticatedEndpoint ;

    /** @var string $guildId */
    private $guildId;

    /**
     * DetailsEndpoint constructor.
     *
     * @param GW2Api $api
     * @param $guildId
     * @param null $apiKey
     */
    public function __construct(GW2Api $api, $guildId, $apiKey = null) {
        parent::__construct($api);

        $this->guildId = $guildId;
        $this->apiKey = $apiKey;
    }

    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url() {
        return 'v2/guild/'.$this->guildId;
    }

    /**
     * Get the guild details.
     *
     * @return mixed
     */
    public function get() {
        return $this->request()->json();
    }
}
