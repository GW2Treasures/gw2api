<?php

namespace GW2Treasures\GW2Api\V2\Authentication;

use GW2Treasures\GW2Api\V2\IEndpoint;

interface IAuthenticatedEndpoint extends IEndpoint {
    /**
     * Get the API key used by this endpoint.
     *
     * @return string
     */
    public function getApiKey();


    /**
     * Set the API key that should be used to request this endpoint.
     *
     * @param string $apiKey
     * @return static
     */
    public function auth($apiKey);
}
