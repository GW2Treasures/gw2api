<?php

namespace Stubs;

use GW2Treasures\GW2Api\V2\Authentication\AuthenticatedEndpoint;

class AuthenticatedEndpointStub extends AuthenticatedEndpoint {
    protected function url() {
        return 'test/stub';
    }

    public function get() {
        return $this->request()->json();
    }
}
