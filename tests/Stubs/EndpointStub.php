<?php

namespace Stubs;

use GW2Treasures\GW2Api\V2\Endpoint;

class EndpointStub extends Endpoint {
    protected function url() {
        return 'test/stub';
    }

    public function test() {
        return $this->request()->json();
    }
}
