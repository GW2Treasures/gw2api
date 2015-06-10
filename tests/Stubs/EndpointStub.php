<?php

namespace Stubs;

use GW2Treasures\GW2Api\V2\Endpoint;

class EndpointStub extends Endpoint {
    public function url() {
        return 'test/stub';
    }

    public function test() {
        return $this->request()->json();
    }

    public function testMany( $count = 2 ) {
        $requests = array_fill( 0, $count, [] );
        $responses = $this->requestMany( $requests );

        $result = [];
        foreach( $responses as $response ) {
            $result = array_merge( $result, $response->json() );
        }

        return $result;
    }
}
