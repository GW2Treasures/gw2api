<?php

namespace GW2Treasures\GW2Api\Endpoint;

trait LocalizedEndpoint {

    /** @var string $language */
    protected $language = 'en';

    /**
     * Get a localized version of this endpoint.
     *
     * @param string $lang
     * @return $this
     */
    public function lang( $lang ) {
        return new LocalizedEndpointProxy( $this, $lang );
    }
}
