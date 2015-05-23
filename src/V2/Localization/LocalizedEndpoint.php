<?php

namespace GW2Treasures\GW2Api\V2\Localization;

use GW2Treasures\GW2Api\V2\EndpointTrait;

trait LocalizedEndpoint {
    use EndpointTrait;

    /** @var string $language */
    protected $language = 'en';

    /**
     * Get a localized version of this endpoint.
     *
     * @param string $lang
     * @return $this
     */
    public function lang( $lang ) {
        /** @noinspection PhpParamsInspection */
        return new LocalizedEndpointProxy( $this, $lang );
    }
}
