<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Achievement;

use GW2Treasures\GW2Api\V2\Endpoint;

class DailyTomorrowEndpoint extends Endpoint {
    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url() {
        return 'v2/achievements/daily/tomorrow';
    }

    /**
     * Get tomorrows daily achievements.
     *
     * @return mixed
     */
    public function get() {
        return $this->request()->json();
    }
}
