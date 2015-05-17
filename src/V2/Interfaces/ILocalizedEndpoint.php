<?php

namespace GW2Treasures\GW2Api\V2\Interfaces;

interface ILocalizedEndpoint {
    /**
     * @param string $language
     * @return $this
     */
    function lang( $language );
}
