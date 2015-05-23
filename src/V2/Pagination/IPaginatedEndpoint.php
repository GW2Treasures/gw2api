<?php

namespace GW2Treasures\GW2Api\V2\Pagination;

use GW2Treasures\GW2Api\V2\IEndpoint;

interface IPaginatedEndpoint extends IEndpoint {
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
