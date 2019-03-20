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

    /**
     * Set the schema version to use when requesting this endpoint.
     *
     * @param string $schema
     * @return $this
     */
    public function schema( $schema );

    /**
     * Get the schema used to request this endpoint.
     * Falls back to the global schema set in the GW2API instance.
     *
     * @return String
     */
    public function getSchema();
}
