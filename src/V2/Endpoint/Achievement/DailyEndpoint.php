<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Achievement;

use GW2Treasures\GW2Api\V2\Endpoint;

class DailyEndpoint extends Endpoint {
    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url() {
        return 'v2/achievements/daily';
    }

    /**
     * Get the current daily achievements.
     *
     * @return mixed
     */
    public function get() {
        return $this->request()->json();
    }
}
