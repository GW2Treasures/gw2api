<?php

namespace GW2Treasures\GW2Api\V2\Interfaces;

interface IBulkEndpoint extends IPaginatedEndpoint {
    /**
     * All ids.
     *
     * @return string[]|int[]
     */
    public function ids();

    /**
     * Single entry by id.
     *
     * @param $id
     * @return mixed
     */
    public function get( $id );

    /**
     * Multiple entries by ids.
     *
     * @param string[]|int[] $ids
     * @return array
     */
    public function many( array $ids );
}
