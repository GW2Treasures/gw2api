<?php

namespace GW2Treasures\GW2Api\V2\Endpoint\Backstory;

use GW2Treasures\GW2Api\V2\Endpoint;

class BackstoryEndpoint extends Endpoint {
    /**
     * The url of this endpoint.
     *
     * @return string
     */
    public function url() {
        return 'v2/backstory';
    }

    public function answers() {
        return new AnswerEndpoint($this->api);
    }

    public function questions() {
        return new QuestionEndpoint($this->api);
    }
}
