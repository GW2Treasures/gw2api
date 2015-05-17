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
    function all();


    /**
     * Get a single page.
     *
     * @param int $index
     * @param int $size
     * @return mixed
     */
    function page( $page, $size = null );
}
