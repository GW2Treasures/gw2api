<?php

namespace GW2Treasures\GW2Api\V2\Authentication;

trait AuthenticatedEndpoint {
    protected $apiKey;

    public function getApiKey() {
        return $this->apiKey;
    }
}
