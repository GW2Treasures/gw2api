<?php

namespace GW2Treasures\GW2Api\V2\Localization;

use GW2Treasures\GW2Api\V2\EndpointTrait;

trait LocalizedEndpoint {
    use EndpointTrait;

    /** @var string $language */
    protected $language = 'en';

    /**
     * Change the language of this endpoint.
     *
     * @param string $lang
     * @return $this
     */
    public function lang( $lang ) {
        $this->language = $lang;
        return $this;
    }

    /**
     * Get the current language.
     *
     * @return string
     */
    public function getLang() {
        return $this->language;
    }
}
