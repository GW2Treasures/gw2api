<?php

namespace GW2Treasures\GW2Api\V2;

interface IEndpoint {
    /**
     * Attach a ApiHandler to this endpoint.
     *
     * @param ApiHandler $handler
     */
    public function attach( ApiHandler $handler );

    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url();
}
