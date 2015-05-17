<?php

namespace GW2Treasures\GW2Api\V2\Interfaces;

interface IPaginatedEndpoint extends IEndpoint {
    /**
     * Max page size of this endpoint.
     *
     * @return int
     */
    function maxPageSize();

    /**
     * All entries.
     *
     * @return array
     */
    public function all();
}
