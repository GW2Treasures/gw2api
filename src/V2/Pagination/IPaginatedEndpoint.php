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
     * @param int $page
     * @param int $size
     * @return mixed
     */
    function page( $page, $size = null );


    /**
     * Get all entries in multiple small batches to minimize memory usage.
     *
     * @param int|null $parallelRequests [optional]
     * @param callable $callback
     * @return void
     */
    function batch( $parallelRequests = null, callable $callback );
}
