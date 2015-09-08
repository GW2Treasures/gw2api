<?php

namespace GW2Treasures\GW2Api\V2\Authentication;

trait AuthenticatedEndpoint {
    /** @var string $apiKey */
    protected $apiKey;

    /**
     * Get the API key used by this endpoint.
     *
     * @return string
     */
    public function getApiKey() {
        return $this->apiKey;
    }
}
