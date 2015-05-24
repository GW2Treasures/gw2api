<?php

namespace GW2Treasures\GW2Api\V2\Localization;

use GW2Treasures\GW2Api\V2\IEndpoint;

interface ILocalizedEndpoint extends IEndpoint {
    /**
     * Change the language of this endpoint.
     *
     * @param string $language
     * @return $this
     */
    public function lang( $language );

    /**
     * Get the current language.
     *
     * @return string
     */
    public function getLang();
}
