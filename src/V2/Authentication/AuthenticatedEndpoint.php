<?php

namespace GW2Treasures\GW2Api\V2\Authentication;

use GW2Treasures\GW2Api\GW2Api;
use GW2Treasures\GW2Api\V2\IParent;

trait AuthenticatedEndpoint {
    /**
     * @return GW2Api
     */
    protected abstract function getApi();

    /**
     * @return IParent
     */
    protected abstract function getParent();

    /** @var string $apiKey */
    protected $apiKey;

    /**
     * Get the API key used by this endpoint.
     *
     * @return string
     */
    public function getApiKey() {
        if(isset($this->apiKey)) {
            return $this->apiKey;
        }

        $parent = $this->getParent();

        while (!($parent instanceof IAuthenticatedEndpoint || $parent instanceof GW2Api)) {
            $parent = $parent->getParent();
        }

        return $parent->getApiKey();
    }

    /**
     * Set the API key that should be used to request this endpoint.
     *
     * @param string $apiKey
     * @return static
     */
    public function auth($apiKey) {
        $this->apiKey = $apiKey;

        return $this;
    }
}
